<?php

namespace Store;

class Products extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=32, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $title;

    /**
     *
     * @var string
     * @Column(type="string", length=53, nullable=true)
     */
    public $price;

    /**
     *
     * @var string
     * @Column(type="string", length=3, nullable=false)
     */
    public $currency;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("products");
        $this->belongsTo('currency', 'Store\Currencies', 'code', ['alias' => 'Currencies']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'products';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Products[]|Products|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Products|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns Product as array of values
     *
     * @return array
     */
    public function getData(): array
    {
        return
        [
            'id'            => (int) $this->id,
            'title'         => $this->title,
            'price'         => (float) $this->price,
            'currency_code' => $this->currency,
            'currency_name' => $this->currencies->name
        ];
    }
}
