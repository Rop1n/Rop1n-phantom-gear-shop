<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\Category;
use app\models\CategoryManufacturer;
use app\models\CategoryFilter;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class CatalogController extends \yii\web\Controller
{
    public function actionMain()
    {
        $categories = Category::find()->all();
        return $this->render('main', ['categories' => $categories]);
    }

    public function actionProduct()
    {
        $id = Yii::$app->request->get('id');
        $category = Category::findOne($id);
        $min = Product::find()->where(['category' => $id])->min('price');
        $max = Product::find()->where(['category' => $id])->max('price');
        $products = Product::find()->where(['category' => $id])->orderBy(['price' => SORT_ASC])->all();
        $manufactures = CategoryManufacturer::find()->where(['category_id' => $id])->all();
        $filters = CategoryFilter::find()->where(['category_id' => $id])->all();
        return $this->render('products', ['products' => $products, 'category' => $category, 'manufactures' => $manufactures, 'filters' => $filters, 'f' => intval($min), 'u' => intval($max), 'm' => "", 's' => "SORT_ASC"]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($model->upload() && $model->save(false)) {
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($model->upload() && $model->save(false)) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

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
                            'allow' => true,
                            'actions' => ['main', 'products', 'product', 'filter'],
                            'roles' => ['?'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['main', 'products', 'product', 'filter'],
                            'roles' => ['@'],
                        ],
                        [
                            'actions' => ['index', 'view', 'create', 'delete', 'update'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return Yii::$app->user->identity->isAdmin();
                            }
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


    public function actionFilter()
    {
        $id = Yii::$app->request->get('id');
        $f = Yii::$app->request->get('f');
        $u = Yii::$app->request->get('u');
        if (!$u) {
            $u = intval(Product::find()->where(['category' => $id])->max('price'));
        }
        $m = Yii::$app->request->get('m');
        $arr = explode(" ", $m);
        $list = [];

        foreach ($arr as $item) {
            $list[] = intval($item);
        }
        $sort = Yii::$app->request->get('s');
        $category = Category::findOne($id);
        if ($m) {
            if ($sort === "SORT_DESC") {
                $products = $category->getProducts()->where(['between', 'price', $f, $u])->andWhere(['in', 'manufacturer_id', $list])->orderBy(['price' => SORT_DESC])->all();
            } else {
                $products = $category->getProducts()->where(['between', 'price', $f, $u])->andWhere(['in', 'manufacturer_id', $list])->orderBy(['price' => SORT_ASC])->all();
            }

        } else {
            if ($sort === "SORT_DESC") {
                $products = $category->getProducts()->where(['between', 'price', $f, $u])->orderBy(['price' => SORT_DESC])->all();
            } else {
                $products = $category->getProducts()->where(['between', 'price', $f, $u])->orderBy(['price' => SORT_ASC])->all();
            }

        }


        $manufactures = CategoryManufacturer::find()->where(['category_id' => $id])->all();
        $filters = CategoryFilter::find()->where(['category_id' => $id])->all();
        return $this->render('products', ['products' => $products, 'category' => $category, 'manufactures' => $manufactures, 'filters' => $filters, 'f' => $f, 'u' => $u, 'm' => $m, 's' => $sort]);
    }



}
