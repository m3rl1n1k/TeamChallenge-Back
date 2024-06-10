<?php

namespace Core\Security;

use Core\Config;
use Core\Container\Container;
use Core\Interface\MiddlewareInterface;
use DiggPHP\Psr11\NotFoundException;

class Middleware
{
	public function middleware($middleware)
	{
		$middleware = $middleware ?? 'guest';
		$class = Config::getValue("middleware.middleware.$middleware");
		/** @var MiddlewareInterface|string $class */
		if ($class)
			Container::call($class)->handler();
		else
			throw new NotFoundException("Middleware not found!");
	}
}