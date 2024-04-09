<?php

namespace App\Core\Controller;

use App\Core\Container\Container;
use App\Core\Header;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    protected Response $response;
    private Header $header;

    protected function responseCall(): void
    {
        $this->response = Container::getInstance()->get(Response::class);
        $this->header = Container::getInstance()->get(Header::class);
    }

    public function response($data, $format = 'json'): Response
    {
        $this->responseCall();
        if ($data === null) {
            return $this->header->sendResponse(null, Response::HTTP_NOT_FOUND);
        }
        if ($format === 'json') {
            $json = json_encode($data);
            return $this->header->sendResponse($json);
        }
        if ($format === 'array') {
            return json_decode($data, true);
        }
        return $this->response;
    }

    public function render(string $path): Response
    {
        require_once ROOT . 'template' . $path . '.php';
        return $this->response;
    }
}