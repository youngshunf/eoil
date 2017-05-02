<?php
return [
    'components' => [
   /*      'db' => [
            'class' => 'yii\db\Connection',     
       // 'dsn' => 'mysql:host=192.168.1.111;dbname=tripclub',
        'dsn' => 'mysql:host=localhost;dbname=wish',
            'username' => 'root',
      // 'password' => 'GRDSgrds2012',
       'password' => '',
            'charset' => 'utf8',
        ], */
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=beauty',
            'username' => 'root',
            'password' => 'YSF2015jzl',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => '',
                'password' => '',
                'port' => '25',
                'encryption' => 'tls',                 
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>[''=>'']
                ],
        ],
        'urlManager' =>[
 			'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
