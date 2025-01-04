<?php

use common\models\VatYear;

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'),
        require(__DIR__ . '/../../common/config/params-local.php'),
        require(__DIR__ . '/params.php'),
        require(__DIR__ . '/params-local.php')
);

return [
    'on beforeAction' => function ($event) {

        \Yii::$app->params['vat'] = VatYear::get_vat_year();
        // \Yii::$app->params['site_setting'] = \common\models\Sitesetting::findOne(1);
    },
    'language' => 'fa-IR',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [//add by Scott
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
    ],
            
            'container' => [
        'definitions' => [
            'yii\widgets\LinkPager' => [
                'firstPageLabel' => 'صفحه اول',
                'lastPageLabel'  => 'صفحه آخر'
            ]
        ]
    ],
    'components' => [
        'cacheBackend' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => Yii::getAlias('@backend') . '/runtime/cache'],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'cacheFrontend' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => Yii::getAlias('@frontend') . '/runtime/cache'
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                //'js'=>[]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                //  'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                //'css' => [], 
                ],
            ],
        ],
        'urlManagerFront' => [
            'enablePrettyUrl' => false,
            'class' => 'yii\web\UrlManager',
            'hostInfo' => '/',
            'baseUrl' => '/',
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
