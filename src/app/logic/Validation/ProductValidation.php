<?php

namespace Logic\Validation;

use \Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Validation\Validator\Callback;

/**
 * Validator for Products create/update requests.
 */
class ProductValidation extends AbstractValidation
{
    /**
     * Initialize validation rules
     *
     * @return void
     */
    public function initialize()
    {
        if($this->request->isPut())
        {
            $this->add(
                'parameterCount',
                new Callback(
                    [
                        'callback' => function($input)
                        {
                            return !!count($this->request->getPut());
                        },
                        'message' => 'At least one property is expected when updating product'
                    ]
                )
            );
        }

        if($this->request->isPost())
        {
            $this->add(
                'title',
                new PresenceOf(
                    [
                        'message' => 'Product title is required',
                        'cancelOnFail' => true,
                    ]
                )
            );

            $this->add(
                'currency',
                new PresenceOf(
                    [
                        'message' => 'Product currency is required',
                        'cancelOnFail' => true,
                    ]
                )
            );


            $this->add(
                'price',
                new PresenceOf(
                    [
                        'message' => 'Product price is required',
                        'cancelOnFail' => true,
                    ]
                )
            );
        }

        $this->add(
            'currencyIntegrity',
            new Callback(
                [
                    'callback' => function($input)
                    {
                        $currency = $this->request->isPut() ? $this->request->getPut('currency') : $this->request->getPost('currency');

                        if(!$currency)
                            return true;

                        $c = \Store\Currencies::findFirst(
                             [
                                'code = :code:',
                                'bind'       => [
                                    'code' => $currency,
                                ]
                            ]
                        );

                        return !!$c;
                    },
                    'message'  => 'Currency code is invalid'
                ]
            )
        );
    }
}