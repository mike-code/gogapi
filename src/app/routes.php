<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Route definition for the /product resource
 */
$app->map('/product[/]?{id:\d*}',
    function($id) use ($app)
    {
        $id = filter_var($id, \FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

        $controller = new \ProductsController();

        if(is_int($id))
        {
            $app->request->isGet()    and $controller->get($id);
            $app->request->isPut()    and $controller->update($id);
            $app->request->isDelete() and $controller->delete($id);
            $app->request->isPost()   and $controller->respondUnsupportedMethod();
        }
        else
        {
            $app->request->isGet()    and $controller->list();
            $app->request->isPost()   and $controller->insert();
            $app->request->isPut()    and $controller->respondUnsupportedMethod();
            $app->request->isDelete() and $controller->respondUnsupportedMethod();
        }
    }
)->via(['GET', 'POST', 'PUT', 'DELETE']);
