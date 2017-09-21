<?php

abstract class Generic extends \Phalcon\Mvc\Controller
{
    protected $handler;

    public function onConstruct()
    {
        $this->handler = $this->di->get('handler');
    }

    protected function render(...$arguments)
    {
        call_user_func_array([$this->handler, 'handle'], $arguments);

        $this->response->setContentType($this->handler->getContentType());
        $this->response->setContent($this->handler->getContentBody());
        $this->response->send();
    }
}
