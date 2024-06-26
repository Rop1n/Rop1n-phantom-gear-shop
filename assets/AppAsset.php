<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style-main.css',
        'js/slick/slick.css',
        'js/slick/slick-theme.css',
        'css/simple-adaptive-slider.css'

    ];
    public $js = [
        'js/simple-adaptive-slider.js',
        'js/slick/slick.min.js',
        'js/main-page/index-main.js',
        'js/index.js',
        'js/productCard.js'


    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
