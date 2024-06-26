<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;

use yii\helpers\Html;

use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
// use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$favicon = Yii::$app->request->baseUrl . '/img/iconSite.ico';

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
// $this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
// $this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
// $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="">


<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
    <link rel="icon" href="<?= $favicon ?>" type="image/x-icon" />
</head>

<body>
    <?php $this->beginBody() ?>


    <header>
        <nav class="navigation-header">
            <ul class="nav-block left-part">
                <li class="header-link">
                    <?= Html::a('КАТАЛОГ', ['/catalog/main'], ['class' => 'bold white']) ?>
                </li>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php if (Yii::$app->user->identity->isadmin == 1): ?>
                        <li class="header-link">
                            <?= Html::a('АДМИНИСТРАТОР', ['/admin'], ['class' => 'bold white']) ?>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

            </ul>
            <!-- <a href="#"> -->
            <?= Html::a('<img class="logo" src="/img/icons/logo.svg" alt="логотип компании">', ['site/index'], ['class' => 'bold white']) ?>

            <!-- </a> -->
            <ul class="nav-block right-part">
                <li>
                    <!-- <a href="/favorite-page/index.html">
                        <img class="icon-link" src="/img/icons/heart.svg" alt="избранное">
                    </a> -->
                    <?= Html::a('<img class="icon-link" src="/img/icons/orders.svg" alt="заказы">', ['/order'], ['class' => 'bold white']) ?>

                </li>
                <li>
                    <!-- <a href="/cart/index.html">
                        <img class="icon-link" src="/img/icons/cart.svg" alt="корзина">
                    </a> -->
                    <?= Html::a('<img class="icon-link" src="/img/icons/cart.svg" alt="корзина">', ['/cart'], ['class' => 'bold white']) ?>
                    <span id="cart-count" class="cart-count"></span>
                </li>
                <li>

                    <?php if (Yii::$app->user->isGuest): ?>
                        <?= Html::a('<img class="icon-link" style="filter: grayscale(100%);" src="/img/icons/profile.svg" alt="профиль">', ['site/login'], ['class' => 'bold white']) ?>
                    <?php else: ?>
                        <?= Html::a('<img class="icon-link"  src="/img/icons/profile.svg" alt="профиль">', ['site/profile'], ['class' => 'bold white']) ?>
                    <?php endif; ?>

                </li>
            </ul>
        </nav>
    </header>

    <main>

        <?= $content ?>

    </main>

    <footer>
        <nav class="navigation-footer">
            <ul class="nav-block left-part">
                <li>
                    <a href="#">
                        <img class="icon-link" src="/img/icons/VK.svg" alt="избранное">
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img class="icon-link" src="/img/icons/tg.svg" alt="корзина">
                    </a>
                </li>
            </ul>

            <img class="logo" src="/img/icons/logo.svg" alt="логотип компании">
            <ul class="contacts">
                <li>
                    <a class="light white" href="tel:+79056148257">+79056148257</a>
                </li>
                <li>
                    <a class="light white" href="mailto:PhantomGear@mail.ru">PhantomGear@mail.ru</a>
                </li>
            </ul>

        </nav>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>


<!-- = Yii::$app->user->identity->username -->