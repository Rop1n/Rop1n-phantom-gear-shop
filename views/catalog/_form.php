<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin( ['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?= $form -> field ($model, 'imageFile')-> fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'blue-button-succes']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
