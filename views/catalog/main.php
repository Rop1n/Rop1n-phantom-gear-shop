<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="background-white ">

    <div class="container-catalog">
        <h1 class="page-name-catalog">Каталог</h1>

        <div class="container-categories">
            <?php foreach ($categories as $category): ?>
                <a href=<?= Url::toRoute(['/catalog/product', 'id' => $category->id]) ?> class="category">
                    <img class="category-icon" src=<?= $category->img ?> alt="">
                    <p class="category-name"><?= $category->name ?> </p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

</div>
