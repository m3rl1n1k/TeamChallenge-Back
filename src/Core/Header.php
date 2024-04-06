<?php

namespace App\Core;

use App\Core\Container\Container;
use Symfony\Component\HttpFoundation\Response;

class Header
{
    private static mixed $response;

    protected function Response(): mixed
    {
        return Container::getInstance()->get(Response::class);
    }

    public function sendContent($content): void
    {
        self::$response = (new Header)->Response();
        self::$response->headers->set('Content-Type', 'application/json');
        self::$response->headers->set('Access-Control-Allow-Origin', '*');
        self::$response->setContent($content);
        self::$response->send();
    }

    public function sendHeader(string $key, string $value): void
    {
        self::$response = (new Header)->Response();
        self::$response->headers->set('Access-Control-Allow-Origin', '*');
        self::$response->headers->set($key, $value);
        self::$response->send();
    }

    public function getHeader($key): ?string
    {
        self::$response = (new Header)->Response();
        return self::$response->headers->get($key);
    }
}