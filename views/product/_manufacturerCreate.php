<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var app\models\Characteristic $model */
/** @var yii\widgets\ActiveForm $form */
$id = Yii::$app->request->get('id');
?>

<div class="characteristic-form">

    <?= Html::a('Вернуться к товарам', ['index'], ['class' => 'btn btn-success']) ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Введите характеристику']) ?>
    <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'blue-button-succes']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>