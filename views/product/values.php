<?php

use app\models\CharacteristicValue;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Product;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->params['breadcrumbs'][] = $this->title;
$id = Yii::$app->request->get('id');
$name = Product::findOne($id)->name;
$this->title = $name.': характеристики';
?>
<div class="characteristic-value-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Заполнить значение характеристики', ['add-value', 'id' => $id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Создать харктеристику', ['add-characteristic', 'id' => $id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Все товары', ['index', 'page'=> 3], ['class' => 'btn btn-success']) ?>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'characteristic_id',
            'product_id',
            'value',
            [
                'format' => 'raw',
                'value' => function ($data) {
                        return '<a href=' . Url::toRoute(['remove', 'id' => $data->id]) . " class='blue-button-succes')>Удалить</a>"
                        ;
                    },


            ],
            [
                'format' => 'raw',
                'value' => function ($data) {
                        return '<a href=' . Url::toRoute(['update-value', 'id_char' => $data->id, 'product_id' => $data->product_id]) . " class='blue-button-succes')>Изменить</a>"
                        ;
                    },


            ],

        ],
    ]); ?>


</div>