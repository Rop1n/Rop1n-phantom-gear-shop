<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Административная панель';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Управление категориями', ['catalog/index'], ['class' => 'profile-link btn btn btn-primary']) ?>
    <?= Html::a('Управление товарами', ['product/index'], ['class' => 'profile-link btn btn btn-primary']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            [
                'label' => 'Статус',
                'attribute' => 'status_id',
                'filter' => ['1' => 'Новый', '2' => 'Подтвержденный', '3' => 'Отклоненный'],
                'value' => 'status.name',
                'filterInputOptions' => ['prompt' => 'Все статусы', 'class' => 'form-control', 'id' => null]
            ],
            [
                'format' => 'raw',
                'label' => 'Количество товаров в заказе',
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
                        $orders = $orders . "<br>" . $item->product->name . " " . $item->count;
                    }
                    return $orders;
                },
            ],

            [
                'format' => 'raw',
                'label' => 'ФИО заказчика',
                'value' => function ($data) {
                    return ' '.$data->user->fullname;
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Адрес заказчика',
                'value' => function ($data) {
                    return ' '.$data->address;
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Номер заказчика',
                'value' => function ($data) {
                    return ' '.$data->user->phone;
                },
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update}',
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                        return true;
                    }
                ]
            ],
        ],
    ]); ?>
