<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Characteristic;

/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
$id = Yii::$app->request->get('product_id');
if (is_null($id)){
    $id = Yii::$app->request->get('id');
}
?>

<div class="product-characteristics">
    <?= Html::a('Вернуться к характеристикам', ['values', 'id' => $id], ['class' => 'btn btn-success']) ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'characteristic_id')->dropDownList(Characteristic::find()->select(['name'])->indexBy('id')->column(), ['prompt' => 'Выберите характристику'])->label('Характеристика') ?>
    <?= $form->field($model, 'value')->textInput(['placeholder' => 'Введите значение характеристики']) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'blue-button-succes']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>