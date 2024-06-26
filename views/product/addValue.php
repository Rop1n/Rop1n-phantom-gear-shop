<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CharacteristicValue $model */

$this->title = 'Заполнение характеристики товара';
$this->params['breadcrumbs'][] = ['label' => 'Characteristic Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_characteristicsValue', [
        'model' => $model,
    ]) ?>

</div>