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
        // Hack: Spatie's ArrayToXml has some problems with objects thus I'm flatting the array
        $data = json_decode(json_encode($this->content_body), true);

        return ArrayToXml::convert($data);
    }

    /**
     * @inheritdoc
     */
    public function getContentType(): string
    {
        return 'text/xml';
    }
}
