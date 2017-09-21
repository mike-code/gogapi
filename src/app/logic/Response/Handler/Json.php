<?php
namespace Logic\Response\Handler;

class Json extends AbstractHandler
{
    /**
     * @inheritdoc
     */
    public function handle(array $data = [], bool $success = true)
    {
        $data =
            [
                'data'  => $data,
                'status' => $success ? 'success' : 'error'
            ];

        $this->content_body = $data;
    }

    /**
     * @inheritdoc
     */
    public function getContentBody(): string
    {
        return json_encode($this->content_body);
    }

    /**
     * @inheritdoc
     */
    public function getContentType(): string
    {
        return 'application/json';
    }
}
