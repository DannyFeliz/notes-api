<?php

use Phalcon\Config;

if (php_sapi_name() === 'cli') {
    define('APP_PATH', realpath('.'));

    require_once __DIR__ . '/../../vendor/autoload.php';
}

//ENV Variables
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../../');
$dotenv->load();

return new Config([
    'database'      => [
        'adapter'  => 'Mysql',
        'host'     => getenv('DATABASE_HOST'),
        'username' => getenv('DATABASE_USER'),
        'password' => getenv('DATABASE_PASS'),
        'dbname'   => getenv('DATABASE_NAME'),
    ],
    'application'   => [
        'version'        => '0.1.0',
        'siteName'       => getenv('DOMAIN'),
        'siteUrl'        => getenv('URL'),
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'imgsDir'        => APP_PATH . '/public/imgs/',
        'baseUri'        => '/',
        'production'     => getenv('PRODUCTION'),
        'debug'          => ['profile' => getenv('DEBUG_PROFILE'), 'logQueries' => getenv('DEBUG_QUERY'), 'logRequest' => getenv('DEBUG_REQUEST')],
        'hmacSecurity'   => getenv('HMCA_SECURITY'),
        'naruhodoUserId' => getenv('NARUHODO_USERID'),
        'uploadDir'      => '/home/dashi-api/public/'
    ],
    'memcache'      => [
        'host' => getenv('MEMCACHE_HOST'),
        'port' => getenv('MEMCACHE_PORT'),
    ],
    'cdn'           => [
        'url' => getenv('CDN_URL'),
    ],
    'naruhodo'      => [
        'url' => getenv('NARUHODO_URL'),
    ],
    'beanstalk'     => [
        'host'   => getenv('BEANSTALK_HOST'),
        'port'   => getenv('BEANSTALK_PORT'),
        'prefix' => getenv('BEANSTALK_PREFIX'),
    ],
    'redis'         => [
        'host' => getenv('REDIS_HOST'),
        'port' => getenv('REDIS_PORT'),
    ],
    'elasticSearch' => [
        'hosts' => getenv('ELASTIC_HOST'), //change to pass array
    ]

]);
