<?php

class ProductsController extends Generic
{
    const PAGE_SIZE = 3;

    public function get(int $id)
    {
        $product = \Store\Products::findFirst($id);

        $data = $product ? $product->getData() : [];

        $this->render($data, true);
    }

    public function list()
    {
        $page = $this->request->get('start') ?? 0;
        $page = filter_var($page, \FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

        $items = array();

        if($page !== FALSE)
        {
            $foundSet = \Store\Products::find(
                [
                     "limit"  => self::PAGE_SIZE,
                     "offset" => self::PAGE_SIZE * $page
                ]
            );

            foreach($foundSet as $item)
            {
                $items[] = $item->getData();
            }
        }

        $this->render(["items" => $items], true);
    }
}

