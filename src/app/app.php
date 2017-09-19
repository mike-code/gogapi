<?php


/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Add your routes here
 */
$app->get('/', function () {
    echo $this['view']->render('index');
});

$app->map('/product[/]?{id:\d*}?',
    function($id) use ($app)
    {
        $id = filter_var($id, \FILTER_VALIDATE_INT);

        $products = new \ProductsController();

        if(is_int($id))
        {
            $app->request->isGet() and $products->get($id);
        }
        else
        {
            $app->request->isGet() and $products->list();
        }
    }
)->via(['GET', 'POST', 'PUT', 'DELETE']);


/**
 * Not found handler
 */
$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});
