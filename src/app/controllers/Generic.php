<?php

abstract class Generic extends \Phalcon\Mvc\Controller
{
    /**
     * Internal storage for response handler
     *
     * @var string
     */
    protected $handler;

    /**
     * Constructor method
     *
     * @return void
     */
    public function onConstruct()
    {
        $this->handler = $this->di->get('handler');
    }

    /**
     * Render response
     *
     * @return \Phalcon\Http\Response
     */
    protected function render(...$arguments)
    {
        call_user_func_array([$this->handler, 'handle'], $arguments);

        $this->response->setContentType($this->handler->getContentType());
        $this->response->setContent($this->handler->getContentBody());
        $this->response->send();

        return $this->response;
    }

    /**
     * Validate HTTP request parameters using validator
     *
     * @param \Logic\Validation\AbstractValidation $validator
     * @return void
     * @throws \Exception
     */
    protected function validateRequest(\Logic\Validation\AbstractValidation $validator)
    {
        $parametersBag = $this->request->get();

        if(!$parametersBag)
        {
            throw new \Exception("Invalid request type for validation");
        }

        $validator->validate($parametersBag);

        if($validator->getLatestMessage())
        {
            $this->render(['message' => $validator->getLatestMessage()], false);
            $this->respondBadRequest();
        }
    }

    /**
     * Halts all actions and sends a 405 Unsupported Method response.
     *
     * @return void
     */
    public function respondUnsupportedMethod()
    {
        throw new \Logic\Exception\UnsupportedMethodException();
    }

    /**
     * Halts all actions and sends a 400 Bad Request response.
     *
     * @return void
     */
    public function respondBadRequest()
    {
        throw new \Logic\Exception\BadRequestException();
    }

    /**
     * Halts all actions and sends a 422 Unprocessable Entity response.
     *
     * @return void
     */
    public function respondUnprocessableEntity()
    {
        throw new \Logic\Exception\UnprocessableEntityException();
    }

    /**
     * Halts all actions and sends a 404 Not Found response.
     *
     * @return void
     */
    public function respondNotFound()
    {
        throw new \Logic\Exception\NotFoundException();
    }

    /**
     * Halts all actions and sends a 401 Unauthorized response.
     *
     * @return void
     */
    public function respondUnauthorized()
    {
        throw new \Logic\Exception\UnauthorizedException();
    }
}
