<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@webroot';

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
