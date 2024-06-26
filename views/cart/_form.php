<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Cart $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cart-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'products')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'blue-button-succes']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
