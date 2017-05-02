<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/../../common/config/params-errorcode.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
    require(__DIR__ . '/../../common/config/params-value-config.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                ],
            ],
        ],
//         'errorHandler' => [
//             'errorAction' => 'site/error',
//         ],
//          'urlManager' => [
//             'enablePrettyUrl' => true,
//             'enableStrictParsing' => true,
//             'showScriptName' => false,
//             'rules' => [
//                 ['class' => 'yii\rest\UrlRule', 'controller' => ['user']],
//             ],
//         ] 
    ],
    'params' => $params,
];
