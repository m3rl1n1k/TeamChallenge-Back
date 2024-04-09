<?php

namespace App\Core;

use App\Core\Container\Container;
use Symfony\Component\HttpFoundation\Response;

class Header
{
    private Response $response;

    public function __construct()
    {
        $this->response = Container::getInstance()->get(Response::class);
    }

    public function getHeader($key): ?string
    {
        return $this->response->headers->get($key);
    }

    public function sendResponse($content, $statusCode = Response::HTTP_OK, $headers = []): Response
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $response = new Response($content, $statusCode, $headers);
        return $response->send();
    }
}