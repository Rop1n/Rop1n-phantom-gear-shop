<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProfileForm $model */

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="background-black ">
    <div class="container-profile">
        <div class="profile-slide" style="opacity: 1;">
            <p class="note note-1">Ваши данные будут использоваться при заказах</p>
            <a class="btn-logout" href="/site/logout">Выход</a>

            <?php $form = ActiveForm::begin(); ?>
            <?php $model->hash = false;?>
            <div class="user-data">
                <div class="form-group short">
                    <?= $form->field($model, 'name')->textInput(['class' => 'input-line-profile', 'id' => 'name'])->label('Ваше имя') ?>
                </div>
                <div class="form-group short">
                    <?= $form->field($model, 'phone')->textInput(['class' => 'input-line-profile', 'id' => 'phone'])->label('Телефон') ?>
                </div>
                <div class="form-group long">
                    <?= $form->field($model, 'username')->textInput(['class' => 'input-line-profile', 'id' => 'username'])->label('Логин') ?>
                </div>
                <div class="form-group long">
                    <?= $form->field($model, 'nickname')->textInput(['class' => 'input-line-profile', 'id' => 'nick-name'])->label('Никнейм') ?>
                </div>
            </div>

            <div class="adress-data">
                <div class="form-group">
                    <?= $form->field($model, 'city')->textInput(['class' => 'input-line-profile', 'id' => 'city'])->label('Город') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'street')->textInput(['class' => 'input-line-profile', 'id' => 'street'])->label('Улица') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'house')->textInput(['class' => 'input-line-profile', 'id' => 'house'])->label('Дом') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'apartment')->textInput(['class' => 'input-line-profile', 'id' => 'apartment'])->label('Квартира') ?>
                </div>
            </div>

            <p class="note note-2">Адрес (будет использоваться для доставок по умолчанию)</p>
            <button type="submit" class="blue-button-profile">
                <p>Сохранить изменения</p>
            </button>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
