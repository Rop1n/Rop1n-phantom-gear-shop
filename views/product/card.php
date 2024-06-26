<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Product $product */

$this->title = $product->name;

$characteristicValues = $product->getCharacteristicValues()->with('characteristic')->all();
?>
<div class="background-white ">
    <div class="container-product-page">
        <div class="page-head">
            <div class="itcss">
                <div class="itcss__wrapper">
                    <div class="itcss__items">
                        <?php foreach ($product->getProductphotos()->all() as $photo): ?>
                            <div class="itcss__item">
                                <img src=<?= $photo->photo ?> width="400" height="400" alt="">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <p class="product-name-card"><?= $product->name ?></p>
            <div class="char-preview">
                <p class="chars-head-small">ХАРАКЕТРИСТИКИ</p>
                <div class="chars-values">
                    <?php
                    $counter = 0;
                    foreach ($characteristicValues as $value):
                        if ($counter < 7): ?>
                            <div class="char-block">
                                <p class="char-name"><?= $value->characteristic->name ?></p>
                                <p class="char-value"><?= $value->value ?></p>
                            </div>
                            <?php
                            $counter++;
                        endif;
                    endforeach; ?>
                </div>
                <a href="#chars" class="more-button">все ХАРАКЕТРИСТИКИ</a>
            </div>
            <?php if (Yii::$app->user->isGuest): ?>
                <div class="price-block ">
                    <p class="price"><?= intval($product->price) ?>₽</p>
                    <a href='/site/login' class="btn-to-cart">Авторизация</a>
                </div>
            <?php else: ?>
                <?php if ($product->isInCart()): ?>
                    <div class="price-block h160">
                        <p class="price"><?= intval($product->price) ?>₽</p>
                        <a href='/cart' class="link-to-cart">Перейти в корзину</a>
                    </div>
                <?php else: ?>
                    <div class="price-block">
                        <p class="price"><?= intval($product->price) ?>₽</p>
                        <button class="btn-to-cart" onclick="toCartClick(<?= $product->id ?>)">В КОРЗИНУ</button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>



        </div>
        <div class="page-bottom">
            <div class="toggle-char">
                <p class="active-char">О товаре</p>
                <p class="non-active-char">ХАРАКЕТРИСТИКИ
                </p>
                <div onclick="toToggle()" class="active-tag"></div>
            </div>
            <div class="description-container">
                <p class="description">
                    <?= $product->descriptionShort ?><span id="dots">...</span><br><br>
                    <span id="more"><?= $product->descriptionMore ?></span>
                </p>
                <button onclick="showMore()" class="desc-more-button">Читать Полностью</button>
            </div>
            <div id="chars" class="char-container hide">
                <?php foreach ($characteristicValues as $value): ?>
                    <div class="char-block-full">
                        <p class="char-name-full"><?= $value->characteristic->name ?></p>
                        <p class="char-value-full"><?= $value->value ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="/catalog/product?id=<?= $product->category ?>" class="blue-button back-button"></a>
        </div>
    </div>
</div>
