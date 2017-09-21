<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

$di->set(
    'handler',
    function () use ($app)
    {
        $handlerType = $app->request->get('format') ?? 'json';
        $handler = null;

        switch ($handlerType)
        {
            case 'xml':
                $handler = new \Logic\Response\Handler\Xml();
                break;
            case 'json':
            default:
                $handler = new \Logic\Response\Handler\Json();
                break;
        }

        return $handler;
    }
);

/**
 * Not found handler
 */
$app->notFound(function () use ($app)
{
    $app->response->setStatusCode(400)->sendHeaders();
});
