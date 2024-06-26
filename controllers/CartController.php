<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Product;
use app\models\Order;
use app\models\Status;
use app\models\OrderProduct;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
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
                    'class' => AccessControl::class,
                    'only' => ['index'],
                    'rules' => [
                        [
                            'actions' => ['index'],
                            'allow' => true,
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
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $itemInCart = \Yii::$app->user->identity->carts;
        if (!$itemInCart) {
            return $this->render('empty');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Cart::find()->where(['user_id' => \Yii::$app->user->identity->id]),
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

    public function actionSucces()
    {
        return $this->render('succes');

    }

    /**
     * Displays a single Cart model.
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

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id_product)
    {
        $product = Product::find()->where(['id' => $id_product])->one();

        if (!$product) {
            return "Такого товара нет";
        }

        $itemInCart = Cart::find()
            ->where(['product_id' => $id_product])
            ->andWhere(['user_id' => \Yii::$app->user->identity->id])
            ->one();

        if (!$itemInCart) {
            $itemInCart = new Cart([
                'product_id' => $id_product,
                'user_id' => \Yii::$app->user->identity->id,
                'count' => 1
            ]);
            $itemInCart->save();
            return "$itemInCart->count";
        }


        $itemInCart->count++;
        $itemInCart->save();

    }

    /**
     * Updates an existing Cart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionCartCount()
    {
        $count = Cart::find()
            ->where(['user_id' => \Yii::$app->user->identity->id])
            ->sum('count');

        \Yii::$app->session->set('cartItemCount', $count);

        return $this->asJson($count);
    }

    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionRemove($id_product)
    {
        $itemInCart = Cart::find()
            ->where(['product_id' => $id_product])
            ->andWhere(['user_id' => \Yii::$app->user->identity->id])
            ->one();

        if (!$itemInCart) {
            return "Товар не найден";
        }

        if ($itemInCart->count - 1 == 0) {
            $itemInCart->delete();
            return "Товар удален";
        }

        $itemInCart->count--;
        $itemInCart->save();
    }

    public function actionDelete($id_product)
    {
        $itemInCart = Cart::find()
            ->where(['product_id' => $id_product])
            ->andWhere(['user_id' => \Yii::$app->user->identity->id])
            ->one();
        $itemInCart->count = 1;
        $itemInCart->delete();
        return "Товар удален";
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //функция добавления товара в корзину
    public function actionByOrder()
    {

        $itemInCart = \Yii::$app->user->identity->carts;
        $user = \Yii::$app->user->identity;

        if (!$itemInCart) {
            return "Корзина пуста";
        }

        if (empty($user->city) || empty($user->street) || empty($user->house) || empty($user->apartment) || empty($user->phone)) {
            return "Заполните контактные данные в своем профиле";
        }

        $order = new Order([
            'user_id' => \Yii::$app->user->identity->id,
            'status_id' => Status::find()->where(['code' => 'new'])->one()->id,
            'address' => "г. " . $user->city . " ул. " . $user->street . " д. " . $user->house . " кв. " . $user->apartment
        ]);
        $order->save();

        foreach ($itemInCart as $item) {
            $itemInOrder = new OrderProduct([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'count' => $item->count,
                'price' => $item->count * $item->product->price
            ]);
            $itemInOrder->save();
            $item->delete();
        }
        return "Заказ сформирован";
    }
}
