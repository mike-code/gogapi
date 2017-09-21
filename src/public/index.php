<?php
declare (strict_types = 1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;

error_reporting(E_ALL);

// Treat warnings, notices etc as fatal errors
set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext)
{
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}, -1);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try
{
    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework.
     */
    $di = new FactoryDefault();

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
     * Include composer autoloader
     */
    require BASE_PATH . '/vendor/autoload.php';

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
     * Include Routes
     */
    include APP_PATH . '/routes.php';

    /**
     * Handle the request
     */
    try
    {
        $app->handle();
    }
    catch(\Logic\Exception\BadRequestException $e)
    {
        $app->response->setStatusCode(400)->sendHeaders();
    }
    catch(\Logic\Exception\NotFoundException $e)
    {
        $app->response->setStatusCode(404)->sendHeaders();
    }
    catch(\Logic\Exception\UnsupportedMethodException $e)
    {
        $app->response->setStatusCode(405)->sendHeaders();
    }
    catch(\Logic\Exception\UnprocessableEntityException $e)
    {
        $app->response->setStatusCode(422)->sendHeaders();
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}
catch (\Exception $e)
{
    $app->response->setStatusCode(500)->sendHeaders();

    if($app->config->debug)
    {
        echo "FATAL: {$e->getMessage()}", PHP_EOL;
        echo $e->getTraceAsString();
    }
    else
    {
        $logger = new \Phalcon\Logger\Adapter\File(BASE_PATH . '/exception_log.txt');
        $logger->critical($e->getMessage() . PHP_EOL . $e->getTraceAsString() . PHP_EOL);
    }
}
