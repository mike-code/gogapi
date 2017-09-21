<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'    => 'Postgresql',
        'host'       => 'pgsql',
        'username'   => 'gog',
        'password'   => 'ITookanArrowintheKnee',
        'dbname'     => 'gog'
    ],

    'application' => [
        'modelsDir'       => APP_PATH . '/models/',
        'logicDir'        => APP_PATH . '/logic/',
        'controllersDir'  => APP_PATH . '/controllers/',
        'migrationsDir'   => APP_PATH . '/migrations/',
        'viewsDir'        => APP_PATH . '/views/',
        'baseUri'         => '/src/',
    ]
]);
