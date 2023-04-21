<?php

use DI\Container;
use NewV\App;
use NewV\Divider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

$services = require_once __DIR__ . "/../config/services.php";
try {
	Container::instance($services);
	$di = Container::instance()->get(App::class);
	$di->handle("https://github.com/Bisix21/php-lessons-p/", "54ac4c9efe");
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
	Divider::printString($e->getMessage());
} catch (InvalidArgumentException $argumentException) {
	Divider::printString($argumentException->getMessage());
}