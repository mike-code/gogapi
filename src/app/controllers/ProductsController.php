<?php

class ProductsController extends \Phalcon\Mvc\Controller
{
    public function get(int $id)
    {
        $product = \Store\Products::find($id)->getFirst();

        if($product)
        {
           echo $product->title, PHP_EOL;
        }

        echo "PID: $id";
    }

    public function list()
    {

    }
}

