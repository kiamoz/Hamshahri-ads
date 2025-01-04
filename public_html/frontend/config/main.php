<?php

use common\models\VatYear;

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
       'on beforeAction' => function ($event) {
            \Yii::$app->params['vat'] = VatYear::get_vat_year();
             //  \Yii::$app->params['site_setting'] = \common\models\Sitesetting::findOne(1);

          
           
    },
    'language' => 'fa-IR',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                    [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Hide index.php
            'showScriptName' => FALSE,
            // Use pretty URLs
            'enablePrettyUrl' => TRUE,
            'baseUrl' => '/',
            'rules' => [
                'post/view/<id:\d+>' => 'post/view',
                'post/view/<id:[\w-]+>' => 'post/view',
                'post/category/<id:\d+>' => 'post/category',
                'post/category/<id:[\w-]+>' => 'post/category',
                '<product:\w+>/view/<id:\d+>' => 'product/view',
                '<product:\w+>/view/<id:[\w-]+>' => 'product/view',
                '<product:\w+>/category/<id:\d+>' => 'product/category',
                '<product:\w+>/category/<id:[\w-]+>' => 'product/category',
            ],
        ],
        'request' => [
            'baseUrl' => '/',
        ],
        
          'assetManager' => [  
            'bundles' => [  
                'yii\web\JqueryAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
   
    /*
      'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
      ],
      ],
     */
    ],
    'params' => $params,
];
