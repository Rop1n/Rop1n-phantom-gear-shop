<?php

use app\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>

<div class="background-white ">

    <div class="container-products-page">
        <p class="page-name-products-page">Каталог</p>
        <div>
            <div class="category-header"><img class="category-icon-header" src="<?= $category->img ?>" alt="">
                <p class="category-name-header"><?= $category->name ?></p>
            </div>
            <div class="sorting"><label class="sorting-label" for="sorting">Сортировка:</label><select
                    class="sorting-select" id="sorting" onchange='categoryFilter(<?= $category->id ?>)'>
                    <option id="s2" class="sorting-select-t" value="SORT_ASC" <?php if ($s === "SORT_ASC"): ?>selected<?php endif; ?>>Цена по возрастанию↑</option>
                    <option id="s1" class="sorting-select" value="SORT_DESC" <?php if ($s === "SORT_DESC"): ?>selected<?php endif; ?>>Цена по убыванию↓</option>


                </select></div>
            <div class="products-and-filters">
                <div class="product-container">
                    <?php if ($products): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product">
                                <a class="product-link" href=<?= Url::toRoute(['product/card', 'id' => $product->id], ) ?>><img
                                        class="product-preview" src="<?= $product->preview ?>" alt="">
                                    <p class="price-prod-page"><?= substr(strval($product->price), 0, -3) ?>₽</p>
                                    <p class="name"><?= $product->name ?></p>
                                </a>
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <?php if ($product->isInCart()): ?>
                                        <button onclick="addCartButtonClick(<?= $product->id ?>, this)"
                                            class="blue-button-prod-page in-cart-prod-page" disabled>В корзине</button>
                                    <?php else: ?>
                                        <button onclick="addCartButtonClick(<?= $product->id ?>, this)" class="blue-button-prod-page">В
                                            корзину</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>По вашему запросу ничего не найдено</p>
                    <?php endif; ?>
                </div>
                <div class="filter-container">
                    <div class="filter-block">
                        <?php foreach ($filters as $filter): ?>
                            <?php if ($filter->filter->name === "цена"): ?>
                                <div class="filter">
                                    <p class="filter-name">ЦЕНА</p>
                                    <div class="from-to-container">
                                        <input class="from-to-input" placeholder="ОТ <?= $f ?>" id="f2" type="number"
                                            inputmode="decimal" title="Введите целое число" value="<?= $f ?>">
                                        <input class="from-to-input" placeholder="ДО <?= $u ?>" id="f3" type="number"
                                            inputmode="decimal" title="Введите целое число" value="<?= $u ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($filter->filter->name === "производители"): ?>
                                <div class="filter" data-id="manufacturer" data-type="check-box">
                                    <p class="filter-name">Производители</p>
                                    <div>
                                        <?php foreach ($manufactures as $manufacturer): ?>

                                            <div class="check-box-row">
                                                <?php
                                                // $position = strpos($m, strval($manufacturer->manufacturer_id));
                                                $arr = explode(" ", $m);
                                                $position = in_array(strval($manufacturer->manufacturer_id), $arr);
                                                if ($position === true) {
                                                    $checked = true;
                                                } else {
                                                    $checked = false;
                                                }
                                                ?>
                                                <input type="checkbox" data-id="<?= $manufacturer->manufacturer_id ?>"
                                                    class="check-box-input mjs" <?php if ($checked): ?>checked<?php endif; ?>
                                                    id="m<?= $manufacturer->id ?>">
                                                <label class="filter-name"
                                                    for="m<?= $manufacturer->id ?>"><?= $manufacturer->manufacturer->name ?></label>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </div>
                    <button class="blue-button-prod-page"
                        onclick='categoryFilter(<?= $category->id ?>)'>Подтвердить</button>
                </div>

                <a href="main" class="blue-button-prod-page back-button"></a>
            </div>

        </div>