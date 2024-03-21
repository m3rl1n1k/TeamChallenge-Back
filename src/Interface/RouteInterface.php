<?php

namespace App\Interface;

interface RouteInterface
{
	public function get(string $uri, string $controller, string $action);
	public function route(string $uriIn, string $methodIn): void;
}