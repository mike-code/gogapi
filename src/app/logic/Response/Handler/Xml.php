<?php
namespace Logic\Response\Handler;

use Spatie\ArrayToXml\ArrayToXml;

class Xml extends AbstractHandler
{
    /**
     * @inheritdoc
     */
    public function handle(array $data = [])
    {
        $this->content_body = $data;
    }

    /**
     * @inheritdoc
     */
    public function getContentBody(): string
    {
        return ArrayToXml::convert($this->content_body);
    }

    /**
     * @inheritdoc
     */
    public function getContentType(): string
    {
        return 'text/xml';
    }
}
