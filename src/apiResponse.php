<?php

namespace Qdns;

use Psr\Http\Message\ResponseInterface;

class APIResponse
{
    private $response;

    /**
     * APIResponse constructor.
     * @param $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = json_decode((string)$response->getBody());
    }

    /**
     * @return bool
     */
    public function isSuccessfull(): bool
    {
        return (bool)$this->response->success;
    }

    /**
     * @return mixed|null
     */
    public function getData()
    {
        return $this->response->data ?? null;
    }
}
