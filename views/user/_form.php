<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); 
       
    ?>
     <?php $model->hash = true;?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rules')->checkbox(['checked' => true]) ?> 



    <div class="form-group">
        <?= Html::submitButton('Регистрация', ['class' => 'blue-button-succes']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>