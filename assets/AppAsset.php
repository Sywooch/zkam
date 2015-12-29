<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/media.css',
        'css/jquery.fancybox.css',
        'css/jquery.autocompleter.css',
    ];
    public $js = [
        'js/jquery.textchange.js',
        'js/select2.full.js',
        'js/script.js',
        'js/jquery.fancybox.pack.js',
        'js/jquery.autocompleter.min.js',




    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'

    ];
}
