<?php

class ProductsController extends Generic
{
    const PAGE_SIZE = 3;

    /**
     * Get single product
     *
     * @required:
     *     - id     - product ID
     *
     * @optional
     *     - format  - response format (xml | json*)
     *
     * @method GET
     * @resource /product/:id
     */
    public function get(int $id)
    {
        $product = \Store\Products::findFirst($id);

        $product or $this->respondNotFound();

        $this->render($product->getData());
    }

    /**
     * Get product list, limited by \ProductsController::PAGE_SIZE
     *
     * @required:
     *     none
     *
     * @optional
     *     - start   - pagination number, starting from 0
     *     - format  - response format (xml | json*)
     *
     * @method GET
     * @resource /product
     */
    public function list()
    {
        $page = $this->request->get('start') ?? 0;
        $page = filter_var($page, \FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

        if($page !== FALSE)
        {
            $items = array();

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

            $this->render(["items" => $items]);
        }
        else
        {
            $this->respondUnprocessableEntity();
        }
    }

    /**
     * Adds product to the database. Returns added product's database ID
     *
     * @required:
     *     - title      - product title
     *     - price      - product price
     *     - currency   - product currency code (must be a valid currency code)
     *
     * @optional
     *     - format  - response format (xml | json*)
     *
     * @method POST
     * @resource /product
     */
    public function insert()
    {
        $this->validateRequest(new \Logic\Validation\ProductValidation());

        $product = new \Store\Products();

        $product->title    = $this->request->getPost('title');
        $product->price    = $this->request->getPost('price');
        $product->currency = $this->request->getPost('currency');

        $product->save();

        $this->render(['id' => $product->id]);
    }

    /**
     * Updates product
     *
     * @required:
     *     - id     - product ID
     *     - At least one of the optional fields
     *
     * @optional
     *     - title      - product title
     *     - price      - product price
     *     - currency   - product currency code (must be a valid currency code)
     *
     * @method PUT
     * @resource /product/:id
     */
    public function update(int $id)
    {
        $this->validateRequest(new \Logic\Validation\ProductValidation());

        $product = \Store\Products::findFirst($id);

        $product or $this->respondNotFound();

        $product->title    = $this->request->getPut('title') ?? $product->title;
        $product->price    = $this->request->getPut('price') ?? $product->price;
        $product->currency = $this->request->getPut('currency') ?? $product->currency;

        if(FALSE === $product->save())
        {
            throw new Exception("Generic error while updating product");
        }
    }

    /**
     * Removes single product
     *
     * @required:
     *     - id     - product ID
     *
     * @optional
     *     none
     *
     * @method DELETE
     * @resource /product/:id
     */
    public function delete(int $id)
    {
        $product = \Store\Products::findFirst($id);

        $product or  $this->respondNotFound();

        if(FALSE === $product->delete())
        {
            throw new Exception("Generic error while deleting product");
        }
    }
}

