<?php
use developeruz\db_rbac\behaviors\AccessBehavior;
$params = require(__DIR__ . '/params.php');

$config = [
    'language'=>'ru',
    'charset'=>'utf-8',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'ipgeobase' => [
            'class' => 'himiklab\ipgeobase\IpGeoBase',
            'useLocalDB' => true,
        ],
        'authManager'  => [
            'class'        => 'yii\rbac\DbManager',
            //            'defaultRoles' => ['guest'],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '12345',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'urlManager'=>[
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                '/register/'=>'site/register',
                '/login'=>'/site/login',
                '/admin'=>'/tree/admin',
                '/russia/arenda/'=>'arenda/default/index',
                '/'=>'/site/index',
                '<city:\D+>/<module:(arenda)\/?>' => 'arenda/default/index',
                '<city:\D+>/arenda/view_ad' => '/arenda/default/view_ad',
                '<city:\D+>/arenda/<cat1:\D+>' => 'arenda/default/index',
                '<city:\D+>/arenda/<cat1:\D+>/<id:\S+>' => 'arenda/default/view_ad',
                //'<city:\D+>' => 'arenda/default/index',
                //'<city:\D+>/arenda/<action:\w+>' => '/arenda/default/',

            ],
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
        'db' => require(__DIR__ . '/db.php'),

    ],
    'modules' => [
        'permit' => [
            'class' => 'developeruz\db_rbac\Yii2DbRbac',
            'params' => [
                'userClass' => 'app\models\User'
            ]
        ],
        'regions' => [
            'class' => 'app\modules\regions\regions',
        ],
        'tree' => [
                'class' => 'app\modules\Tree\Tree',
        ],
        'arenda' => [
            'class' => 'app\modules\arenda\arenda',
        ],

    ],

    'params' => $params,
    'as AccessBehavior' => [
        'class' => AccessBehavior::className(),
        'rules' =>
            ['site' =>
                [
                    [
                        'actions' => [],
                        'allow' => true,
                    ],

                ],
                'arenda/default' =>
                    [
                        [
                            'allow' => true,
                        ],
                    ],
                'debug/default' =>
                    [
                        [
                            'allow' => true,
                        ],
                    ],

            ],



    ]

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
