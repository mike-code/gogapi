<?php

namespace Logic\Validation;

interface IValidation
{
    public function initialize();

    public function getLatestMessage();
}