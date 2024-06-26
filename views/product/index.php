<?php


use app\models\Manufacturer;
use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Category;


/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать товар', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Создать производителя', ['create-manufacturer'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'price',
            [
                'attribute' => 'category',
                'value' => 'category0.name',
                'filter' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
                'filterInputOptions' => ['prompt' => 'Все категории', 'class' => 'form-control', 'id' => null]
            ],
            [
                'attribute' => 'manufacturer_id',
                'value' => 'manufacturer.name',
                'filter' => ArrayHelper::map(Manufacturer::find()->all(), 'id', 'name'),
                'filterInputOptions' => ['prompt' => 'Все бренды', 'class' => 'form-control', 'id' => null]
            ],

            [
                'format' => 'html',
                'label' => 'Характеристики',
                'value' => function ($data) {
                        $list = '';
                        foreach ($data->characteristicValues as $item) {
                            $list = $list . "<br>" . $item->value;
                        }
                        return $list;
                    },
            ],
            [
                'format' => 'raw',
                'value' => function ($data) {
                        return '<a href=' . Url::toRoute(['values', 'id' => $data->id]) . " class='btn btn-success')>Просмотр</a>" . "&nbsp;&nbsp;"
                        ;
                    }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
            ],


        ],
    ]); ?>


</div>