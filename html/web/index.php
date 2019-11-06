<?php

$server = $_SERVER;
$serverName = $server['SERVER_NAME'];
$domainComponents = explode('.', $serverName);
$domainExtension = end($domainComponents);

$sslCheck = isset($server['HTTPS']) ? true : false;
$port = $server['SERVER_PORT'];
$sslEnabled = $sslCheck && $port == '443' ? true : false;
define('SSL_ENABLED', $sslEnabled);
define('DOMAIN_EXTENSION', strtolower($domainExtension));

switch ($serverName) {
    case "api.accumedintel.net":
        define('ENVIRONMENT', 'production');
        break;
    case "api-staging.accumedintel.net":
        define('ENVIRONMENT', 'staging');
        break;
    default:
        define('ENVIRONMENT', 'local');
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
        break;
}
define('IS_TRUE', 1);
define('IS_FALSE', 0);
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');
(new yii\web\Application($config))->run();
