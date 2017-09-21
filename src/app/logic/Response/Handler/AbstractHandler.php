<?php
namespace Logic\Response\Handler;

abstract class AbstractHandler
{
	/**
     * Internal storage for response body
     *
     * @var string
     */
    protected $content_body;

    /**
     * Handle response
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Get response content body
     *
     * @return string
     */
    abstract public function getContentBody(): string;

    /**
     * Get response content type
     *
     * @return string
     */
    abstract public function getContentType(): string;
}
