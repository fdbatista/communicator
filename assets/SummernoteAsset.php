<?php

namespace app\assets;

use yii\web\AssetBundle;

class SummernoteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'js/plugins/summernote-0.8.18/summernote.min.css',
    ];

    public $js = [
        'js/plugins/summernote-0.8.18/init.js',
        'js/plugins/summernote-0.8.18/summernote.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
