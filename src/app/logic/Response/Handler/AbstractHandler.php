<?php
namespace Logic\Response\Handler;

abstract class AbstractHandler
{
    protected $content_body;

    abstract public function handle();

    abstract public function getContentBody(): string;

    abstract public function getContentType(): string;
}
