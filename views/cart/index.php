<?php

use app\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;



/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="background-black">
    <div class="container-cart">
        <p class="page-name-cart"><?= Html::encode($this->title) ?></p>

        <div class="cart-container">
            <?php Pjax::begin(['id' => 'cart']) ?>
            <div class="product-container-cart">
                <?php foreach ($dataProvider->models as $cartItem): ?>
                    <div class="product-cart" data-id="<?= $cartItem->product_id ?>">
                        <button class="button-delete" onclick="deleteCart(<?= $cartItem->product_id ?>)"></button>
                        <div class="product-background">
                            <img class="product-preview-cart" src="<?= $cartItem->product->preview ?>" alt="фото товара">
                            <p class="price-cart"><?= intval($cartItem->product->price) ?>₽</p>
                            <p class="product-name-cart"><?= $cartItem->product->name ?></p>
                            <div class="counter-container">
                                <button class="button-counter minus"
                                    onclick="removeCart(<?= $cartItem->product_id ?>)">-</button>
                                <input type="number" value="<?= $cartItem->count ?>" class="amount-cart" min="1">
                                <button class="button-counter plus"
                                    onclick="addCart(<?= $cartItem->product_id ?>)">+</button>
                            </div>
                            <div class="price-sum-container">
                                <p class="price-sum-head">СУММА:</p>
                                <p class="price-sum-cart"><?= $cartItem->count * $cartItem->product->price ?>₽</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="total-cart">
                <p class="total-head">итого:</p>
                <p class="total-value"><?= Cart::getSum() ?> ₽</p>
            </div>
            <?php Pjax::end() ?>
        </div>
        <div class="info alert-cart"></div>

        <div class="form-group">
            <button onclick="byOrder()" class="blue-button-succes">Оформить заказ</button>
        </div>
    </div>
</div>