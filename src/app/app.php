<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Inject response handler based on 'format' request parameter.
 * The default format is application/json
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
    throw new \Logic\Exception\NotFoundException();
});
