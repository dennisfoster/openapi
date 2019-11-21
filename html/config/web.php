<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            // ...
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->statusCode == 401) {
                    $response->data = [
                        'error' => $response->data['message']
                    ];
                }
                if ($response->statusCode == 404) {
                    $response->data = [
                        'error' => 'Not found'
                    ];
                    $response->format = \yii\web\Response::FORMAT_JSON;
                }
            }
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
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
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key' => 'file:///etc/keys/openapi/pubkey.pem',
            // You have to configure ValidationData informing all claims you want to validate the token.
            'jwtValidationData' => \app\components\JwtValidationData::class,
        ],
        'db' => require(__DIR__ . '/db.php'),
        'dbPackage' => require(__DIR__ . '/dbPackage.php'),
        'dbIntranet' => require(__DIR__ . '/dbIntranet.php'),        
        // 'response' => require(__DIR__ . '/response.php'),
        'urlManager' => require(__DIR__ . '/route.php'),
        'amazon' => [
            'class' => 'app\components\amazon\Amazon',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
//    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//    ];
//
//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//    ];
}

return $config;
