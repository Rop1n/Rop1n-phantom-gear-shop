<?php

use app\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'корзина';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="background-black">
    <div class="container-order">

        <form action="<?= Url::to(['/cart/submit-order']) ?>" method="post">
            <div class="order-container">
                <div class="personal-info">
                    <div class="form-group">
                        <label class="input-name" for="name">Имя</label>
                        <input class="input-line" type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label class="input-name" for="email">Email</label>
                        <input class="input-line" type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label class="input-name" for="phone">Телефон</label>
                        <input class="input-line" type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label class="input-name" for="notes">Примечания к заказу</label>
                        <textarea class="input-line aditional-info" id="notes" name="notes"></textarea>
                    </div>
                </div>
                <div class="order-info">
                    <div class="form-group">
                        <label class="input-name" for="city">Город</label>
                        <input class="input-line" type="text" id="city" name="city" required>
                    </div>
                    <div class="form-group">
                        <label class="input-name" for="street">Улица</label>
                        <input class="input-line" type="text" id="street" name="street" required>
                    </div>
                    <div class="form-group">
                        <label class="input-name" for="house">Дом</label>
                        <input class="input-line" type="text" id="house" name="house" required>
                    </div>
                    <div class="form-group">
                        <label class="input-name" for="apartment">Квартира</label>
                        <input class="input-line" type="text" id="apartment" name="apartment" required>
                    </div>
                </div>
            </div>
            <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-success']) ?>
        </form>
    </div>
</div>