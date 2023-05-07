<?php

use DI\Config;
use DI\Container;
use Classes\App;
use Classes\Divider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

const ROOT = __DIR__ . "/../";
require_once ROOT . "src/bootstrap.php";
$services = Config::instance()->get("services");
try {
	Container::getInstance($services);
	$di = Container::getInstance()->get(App::class);
	$di->handle("https://google.com/", "008ec4453f");
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
	Divider::printString($e->getMessage());
} catch (InvalidArgumentException $argumentException) {
	Divider::printString($argumentException->getMessage());
}