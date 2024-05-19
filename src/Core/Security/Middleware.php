<?php

namespace App\Core\Security;

use App\Core\Config;
use App\Core\Container\Container;

use App\Core\Interface\MiddlewareInterface;
use DiggPHP\Psr11\NotFoundException;

class Middleware
{
    public function middleware($middleware)
    {
        $middleware = $middleware ?? 'guest';
        $class = Config::getValue("middleware.middleware.$middleware");
        /** @var MiddlewareInterface|string $class */
        if ($class)
            $response = Container::call($class)->handler();
        else
            $response = throw new NotFoundException("Middleware not found!");
        return $response;
    }
}