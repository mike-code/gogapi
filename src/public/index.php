<?php
declare (strict_types = 1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;

error_reporting(E_ALL);

// Treat warnings, notices etc as fatal errors
set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}, -1);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try
{

    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();


    /**
     * Include Routers
     */
    // include APP_PATH . '/config/router.php';

    /**
     * Include Services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Starting the application
     * Assign service locator to the application
     */
    $app = new Micro($di);

    /**
     * Include Application
     */
    include APP_PATH . '/app.php';

    /**
     * Handle the request
     */
    $app->handle();

}
catch (\Exception $e)
{
    $app->response->setStatusCode(500, "Server Error")->sendHeaders();
    echo "FATAL: {$e->getMessage()} <br>";
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
