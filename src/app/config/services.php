<?php

use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;

/**
 * Shared configuration service
 */
$di->setShared('config', function ()
{
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function ()
{
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function ()
{
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => ''
    ];

    if ($config->database->adapter == 'Postgresql')
    {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});

/**
 * Shared session service
 */
$di->setShared(
    'session',
    function ()
    {
        $session = new \Phalcon\Session\Adapter\Files();

        $session->start();

        return $session;
    }
);


/**
 * Shared cache service
 */
$di->setShared(
    'cache',
    function ()
    {
        $cache = new \Phalcon\Cache\Backend\Redis(
            new \Phalcon\Cache\Frontend\Json(
            [
                'lifetime' => 3600, // 1 hour
            ]),
            [
                'prefix'     => '_GOG_',
                'host'       => 'redis',
                'port'       => 6379,
                'persistent' => false,
                'index'      => 0,
            ]
        );

        return $cache;
    }
);
