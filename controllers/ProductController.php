<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\Manufacturer;
use app\models\Productcharacteristic;
use app\models\CharacteristicValue;
use app\models\Characteristic;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\Productphoto;

use app\models\ProductSearch;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['*'],
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'card', 'delete', 'update', 'add-value', 'create-manufacturer', 'update-value', 'add-characteristic', 'remove', 'values'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return Yii::$app->user->identity->isAdmin();
                            }
                        ],
                        [
                            'allow' => true,
                            'actions' => ['card'],
                            'roles' => ['?'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['card'],
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Product();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->previewFile = UploadedFile::getInstance($model, 'previewFile');
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');

                if ($model->save(false)) {
                    if ($model->previewFile && $model->uploadPreview()) {
                        $model->save(false);
                    }

                    $filePaths = $model->uploadFiles();
                    if ($filePaths) {
                        foreach ($filePaths as $filePath) {
                            $photo = new ProductPhoto();
                            $photo->product_id = $model->id;
                            $photo->photo = $filePath;
                            $photo->save();
                        }
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Product::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("The product was not found.");
        }



        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->previewFile = UploadedFile::getInstance($model, 'previewFile');
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if (boolval($model->is_new)):
                    Product::updateAll(['is_new' => null]);
                endif;

                // Удаление старого превью только если загружено новое превью
                if ($model->previewFile) {
                    $model->deleteOldPreview();
                }

                // Удаление старых фото только если загружены новые фото
                if (!empty($model->imageFiles)) {
                    $model->deleteOldPhotos();
                    ProductPhoto::deleteAll(['product_id' => $model->id]);
                }

                if ($model->save(false)) {
                    if ($model->previewFile && $model->uploadPreview()) {
                        $model->save(false);
                    }

                    $filePaths = $model->uploadFiles();
                    if ($filePaths) {
                        foreach ($filePaths as $filePath) {
                            $photo = new ProductPhoto();
                            $photo->product_id = $model->id;
                            $photo->photo = $filePath;
                            $photo->save();
                        }
                    }
                    return $this->redirect(['index']);
                }

            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }




    public function actionValues($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CharacteristicValue::find()->where(['product_id' => $id]),
        ]);

        return $this->render('values', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAddValue($id)
    {
        $model = new CharacteristicValue();
        $model->product_id = $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['values', 'id' => $id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('addValue', [
            'model' => $model,
        ]);
    }

    public function actionAddCharacteristic($id)
    {
        $model = new Characteristic();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['values', 'id' => $id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('addCharacteristic', [
            'model' => $model,
        ]);
    }

    public function actionCreateManufacturer()
    {
        $model = new Manufacturer();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('addManufacturer', [
            'model' => $model,
        ]);
    }

    public function actionChange($id)
    {
        $model = $this->findModelValue($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('change', [
            'model' => $model,
        ]);
    }

    public function actionRemove($id)
    {
        $this->findModelValue($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUpdateValue($id_char, $product_id)
    {
        $model = CharacteristicValue::findOne($id_char);
        $model->product_id = $product_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['values', 'id' => $product_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('addValue', [
            'model' => $model,
        ]);
    }

    protected function findModelValue($id)
    {
        if (($model = CharacteristicValue::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }




    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionCard($id)
    {
        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException("Product with ID $id not found.");
        }
        return $this->render('card', ['product' => $product]);
    }
}
