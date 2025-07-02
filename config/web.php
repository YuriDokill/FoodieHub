<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1'],
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1'],
            'panels' => [
                'db' => [
                    'class' => 'yii\debug\panels\DbPanel',
                    'explain' => false, // Отключаем EXPLAIN запросов
                ]
            ],
            'historySize' => 5, // Уменьшаем количество хранимых запросов
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'tBkIngkNNX-XQyfABMJLAsQmeGfXJGL5',
            'enableCsrfCookie' => true,
            'baseUrl' => '/foodiehub/web',
            'csrfParam' => '_csrf-foodiehub',
        ],
        'pdf' => [
            'class' => 'yii\mpdf\Pdf',
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'portrait',
            'destination' => 'browser',
            'options' => ['title' => 'Бюджетный отчет'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap5\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\bootstrap5\BootstrapPluginAsset' => [
                    'js' => []
                ],
            ],
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => 0,
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'logFile' => '@runtime/logs/app.log',
                    'maxFileSize' => 1024 * 2, // 2MB
                    'maxLogFiles' => 20,
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'yii2fullcalendar*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'yii2fullcalendar' => 'yii2fullcalendar.php',
                    ],
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'currencyCode' => 'RUB',
            'locale' => 'ru-RU',
            'defaultTimeZone' => 'Europe/Moscow',
            'dateFormat' => 'php:d.m.Y',
            'datetimeFormat' => 'php:d.m.Y H:i',
            'timeFormat' => 'php:H:i',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm',
            'timeFormat' => 'HH:mm',
            'locale' => 'ru-RU',
            'defaultTimeZone' => 'Europe/Moscow',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'viewPath' => '@app/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'your@email.com',
                'password' => 'your-password',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => '/foodiehub/web',
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'signup' => 'site/signup',
                'logout' => 'site/logout',
        
                'event' => 'event/index',
                'event/<id:\d+>' => 'event/view',
                'event/create' => 'event/create',
                'event/update/<id:\d+>' => 'event/update',
                'event/delete/<id:\d+>' => 'event/delete',
                'event/calendar' => 'event/calendar',
                
                'recipe' => 'recipe/index',
                'recipe/<id:\d+>' => 'recipe/view',
                'recipe/create' => 'recipe/create',
                'recipe/update/<id:\d+>' => 'recipe/update',
                'recipe/delete/<id:\d+>' => 'recipe/delete',
                
                'restaurant' => 'restaurant/index',
                'restaurant/<id:\d+>' => 'restaurant/view',
                'restaurant/create' => 'restaurant/create',
                'restaurant/update/<id:\d+>' => 'restaurant/update',
                'restaurant/delete/<id:\d+>' => 'restaurant/delete',
                
                'task' => 'task/index',
                'task/<id:\d+>' => 'task/view',
                'task/create' => 'task/create',
                'task/update/<id:\d+>' => 'task/update',
                'task/delete/<id:\d+>' => 'task/delete',
                
                'guest' => 'guest/index',
                'guest/<id:\d+>' => 'guest/view',
                'guest/create' => 'guest/create',
                'guest/update/<id:\d+>' => 'guest/update',
                'guest/delete/<id:\d+>' => 'guest/delete',
                
                'expense' => 'expense/index',
                'expense/<id:\d+>' => 'expense/view',
                'expense/create' => 'expense/create',
                'expense/update/<id:\d+>' => 'expense/update',
                'expense/delete/<id:\d+>' => 'expense/delete',
                'expense/export-excel/<event_id:\d+>' => 'expense/export-excel',
                
                'event-category' => 'event-category/index',
                'event-category/<id:\d+>' => 'event-category/view',
                'event-category/create' => 'event-category/create',
                'event-category/update/<id:\d+>' => 'event-category/update',
                'event-category/delete/<id:\d+>' => 'event-category/delete',
                
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
