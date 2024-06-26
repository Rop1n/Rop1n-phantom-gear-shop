<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CharacteristicValue $model */

$this->title = 'Создание производителя';
$this->params['breadcrumbs'][] = ['label' => 'Characteristics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_manufacturerCreate', [
        'model' => $model,
    ]) ?>

</div>