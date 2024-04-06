<?php

namespace App\Core;

use App\Core\Container\Container;
use Symfony\Component\HttpFoundation\Response;

class Header
{
    private mixed $response;

    public function __construct()
    {
        $this->response = Container::getInstance()->get(Response::class);
    }

    public function sendContent($content): void
    {
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->headers->set('Access-Control-Allow-Origin', '*');
        $this->response->setContent($content);
        $this->response->send();
    }

    public function sendHeader(string $key, string $value): void
    {
        $this->response->headers->set('Access-Control-Allow-Origin', '*');
        $this->response->headers->set($key, $value);
        $this->response->send();
    }

    public function getHeader($key): ?string
    {
        return $this->response->headers->get($key);
    }
}