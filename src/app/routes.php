<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

$app->map('/product[/]?{id:\d*}',
    function($id) use ($app)
    {
        $id = filter_var($id, \FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

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
