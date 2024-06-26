<?php

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

       <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'date',
            'status.name',
            [
                'format' => 'raw',
                'label' => 'Количество позиций в заказе',
                'value' => function ($data) {
                    return count($data->orderProducts);
                },
            ],
            [
                'format' => 'html',
                'label' => 'Список товаров',
                'value' => function ($data) {
                    $orders = '';
                    foreach ($data->orderProducts as $item) {
                        $orders = $orders . "<br>" . $item->product->name . " количество: " . $item->count;
                    }
                    return $orders;
                },
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{delete}',
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        return $model->status->code == 'new';
                    }
                ]
            ],
        ],
    ]); ?>


</div>
