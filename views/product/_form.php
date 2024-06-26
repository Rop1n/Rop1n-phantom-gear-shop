<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;
use app\models\Characteristic;
use app\models\CharacteristicValue;
use app\models\Manufacturer;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name')) ?>
    <?= $form->field($model, 'manufacturer_id')->dropDownList(ArrayHelper::map(Manufacturer::find()->asArray()->all(), 'id', 'name')) ?>
    <?= $form->field($model, 'previewFile')->fileInput(['accept' => 'image/*']) ?>
    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <?= $form->field($model, 'descriptionShort')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'descriptionMore')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'is_new')->radioList( [1 =>'Промо-товар'], ['unselect' => null] ); ?>






    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'blue-button-succes']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

