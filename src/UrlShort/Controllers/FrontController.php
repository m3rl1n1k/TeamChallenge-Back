<?php

namespace Bisix21\src\UrlShort\Controllers;

use Bisix21\src\Core\Handler;
use Bisix21\src\UrlShort\Services\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class FrontController
{
	public function __construct(
		protected Handler $handler,
		protected Request $request
	)
	{
	}

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function simpleRoute(): void
	{
		match ($this->request->getRequestUrl()) {
			'/' => $this->handler->handle()
		};
	}
}