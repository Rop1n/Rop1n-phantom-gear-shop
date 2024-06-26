<?php

use yii\helpers\ArrayHelper;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status_id')
        ->dropDownList(ArrayHelper::map(\app\models\Status::find()->asArray()->all(),'id','name'))  ?>

    <?= $form->field($model, 'rejection_reason')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'blue-button-succes']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
