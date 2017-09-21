<?php

class CartController extends Generic
{
    const MAX_CART_SIZE = 3;

    /**
     * Internal storage for cache key
     *
     * @var string
     */
    protected $cacheKey;

    /**
     * @inheritdoc
     */
    public function onConstruct()
    {
        parent::onConstruct();

        $this->cacheKey = 'cart_' . $this->session->getId();
    }

    /**
     * Checks if cart has already been created for current sessions
     *
     * @return bool
     */
    public function isCreated()
    {
        return !!$this->cache->get($this->cacheKey);
    }

    /**
     * Creates cart and stores it in cache
     *
     * @required:
     *     none
     *
     * @optional
     *     none
     *
     * @method POST
     * @resource /cart
     */
    public function create()
    {
        if($this->isCreated()) return;

        $this->cache->save($this->cacheKey,
            [
                'items' => array()
            ]);
    }

    /**
     * Adds product to the current cart
     *
     * @required:
     *     - id     - product ID
     *
     * @optional
     *     none
     *
     * @method POST
     * @resource /cart/product/:id
     */
    public function addProduct(int $id)
    {
        $product = \Store\Products::findFirst($id);

        $product or $this->respondNotFound();

        $data = $this->cache->get($this->cacheKey);

        if(count($data->items) === self::MAX_CART_SIZE)
        {
            $this->response->setStatusCode(403);
            $this->render(['message' => 'You cannot add more items to the cart'], false);
        }
        else
        {
            $data->items[] = $product->getData();
            $this->cache->save($this->cacheKey, $data);
        }
    }

    /**
     * Removes product from the currect cart
     *
     * @required:
     *     - id     - product ID
     *
     * @optional
     *     none
     *
     * @method DELETE
     * @resource /cart/product/:id
     */
    public function deleteProduct(int $id)
    {
        $data = $this->cache->get($this->cacheKey);

        foreach($data->items as $key => $item)
        {
            if($id === $item->id)
            {
                unset($data->items[$key]);
                $data->items = array_values($data->items);

                $this->cache->save($this->cacheKey, $data);
                return;
            }
        }

        $this->respondNotFound();
    }

    /**
     * List all items from the currect cart together with theirs total
     *
     * @required:
     *     none
     *
     * @optional
     *     - format  - response format (xml | json*)
     *
     * @method GET
     * @resource /cart
     */
    public function listProducts()
    {
        // todo: Here I should implement currency conversion logic but I can't be bothered ayy lmao
        //       please don't kill me with jet fuel yet

        $data = $this->cache->get($this->cacheKey);

        $output =
        [
            'items' => [],
            'total' => 0,
        ];

        $output['items'] += $data->items;

        foreach($output['items'] as $item)
        {
            $output['total'] += $item->price;
        }

        $this->render($output);
    }
}
