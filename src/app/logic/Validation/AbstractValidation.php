<?php

namespace Logic\Validation;

abstract class AbstractValidation extends \Phalcon\Validation implements IValidation
{
    /**
     * Returns latest validation error message.
     *
     * @return string|NULL
     */
    public function getLatestMessage()
    {
        if(count($this->getMessages()))
        {
            return $this->getMessages()->current()->__toString();
        }
        else
        {
            return null;
        }
    }
}