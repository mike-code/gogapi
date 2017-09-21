<?php
namespace Logic\Response\Handler;

use Spatie\ArrayToXml\ArrayToXml;

class Xml extends AbstractHandler
{
    public function handle(array $data = [])
    {
        $this->content_body = $data;
    }

    public function getContentBody(): string
    {
        return ArrayToXml::convert($this->content_body);
    }

    public function getContentType(): string
    {
        return 'text/xml';
    }
}
