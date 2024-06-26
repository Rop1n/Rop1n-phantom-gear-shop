<?php

/** @var yii\web\View $this */
use yii\helpers\Html;
use app\models\Product;

$this->title = 'Phantom Gear';
?>

<section class="promo-slider-container">
    <div class="promo-slider">
        <div class="promo-slide">
            <img src="/img/promo-slides/slide-1.png" alt="">
            <a href="/product/card?id=9041" class="more-btn"></a>
        </div>
        <div class="promo-slide">
            <img src="/img/promo-slides/slide-2.png" alt="">
            <a href="/product/card?id=9118" class="more-btn"></a>
        </div>
        <div class="promo-slide">
            <img src="/img/promo-slides/slide-3.png" alt="">
            <a href="/product/card?id=9013" class="more-btn"></a>
        </div>
        <div class="promo-slide">
            <img src="/img/promo-slides/slide-4.png" alt="">
            <a href="/product/card?id=9135" class="more-btn"></a>
        </div>
        <div class="promo-slide">
            <img src="/img/promo-slides/slide-5.png" alt="">
            <a href="/product/card?id=9099" class="more-btn"></a>
        </div>
    </div>
</section>
<section class="catalog-slider-container">
    <p>наши товары</p>

    <div class="catalog-slider" data-slick='{"slidesToShow": 7, "slidesToScroll": 1}'>
        <div class="category-slider"><a href="/catalog/product?id=1"><img
                    src="/img/categories-mini/chair.png"></a></div>
        <div class="category-slider"><a href="/catalog/product?id=8"><img
                    src="/img/categories-mini/gamepad.png"></a></div>
        <div class="category-slider"><a href="/catalog/product?id=6"><img
                    src="/img/categories-mini/headphonespng.png"></a></div>
        <div class="category-slider"><a href="/catalog/product?id=9"><img
                    src="/img/categories-mini/keyboard.png"></a></div>
        <div class="category-slider"><a href="/catalog/product?id=10"><img
                    src="/img/categories-mini/microphone.png"></a></div>
        <div class="category-slider"><a href="/catalog/product?id=5"><img
                    src="/img/categories-mini/mouse-pad.png"></a></div>
        <div class="category-slider"><a href="/catalog/product?id=3"><img
                    src="/img/categories-mini/monitor.png"></a></div>
        <div class="category-slider"><a href="/catalog/product?id=2"><img
                    src="/img/categories-mini/mouse.png"></a></div>
        <div class="category-slider"><a href="/catalog/product?id=7"><img
                    src="/img/categories-mini/steering-wheel.png"></a></div>
        <div class="category-slider"><a href="/catalog/product?id=4"><img
                    src="/img/categories-mini/table.png"></a></div>

    </div>
</section>
<?php
$product = Product::findOne(["is_new" => true]);
if ($product !== null): ?>
            <section class="promo-product">


                <p class="promo-header">Новинка</p>
                <div class="products-container-row">
                    <div class="slider">
                        <div class="itcss__wrapper">
                            <div class="itcss__items">
                            <?php foreach ($product->getProductphotos()->all() as $photo): ?>
                                                        <div class="itcss__item">
                                                            <img src=<?= $photo->photo ?> width="400" height="400" alt="">
                                                        </div>
                                    <?php endforeach; ?>
                                <!-- <div class="itcss__item">
                        <img src="/uploads/TW7o_Viu.png" width="400" height="400" alt="">
                    </div>
                    <div class="itcss__item">
                        <img src="/uploads/V2UyHvPw.png" width="400" height="400" alt="">
                    </div>
                    <div class="itcss__item">
                        <img src="/uploads/jKbx4rEi.png" width="400" height="400" alt="">
                    </div>
                    <div class="itcss__item">
                        <img src="/uploads/BINxSRS2.png" width="400" height="400" alt="">
                    </div>
                    <div class="itcss__item">
                        <img src="/uploads/JQup8u9v.png" width="400" height="400" alt="">
                    </div> -->

                            </div>
                        </div>
                    </div>
                    <div class="product-container-column">
                        <p class="product-name-main"><?= $product->name ?></p>
                        <p class="product-description"><?= $product->descriptionShort ?></p>
                        <a href="/product/card?id=<?= $product->id ?>" class="more-info">подробнее</a>
                    </div>
                </div>

    </section>
<?php endif ?>
<section class="about-us">
    <div class="about-us-row">
        <img src="/img/delivery.png" width="250" alt="">

        <img src="/img/good-price.png" width="253" alt="">

        <img src="/img/guarantee.png" width="212" alt="">
    </div>
    <?= Html::a('О нас', ['site/about'], ['class' => 'more-info']) ?>
</section>
