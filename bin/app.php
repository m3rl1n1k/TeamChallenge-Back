<?php


use Bisix21\src\Classes\Divider;
use Bisix21\src\Classes\Handler;
use Bisix21\src\Core\Config;
use Bisix21\src\Core\DI\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

const ROOT = __DIR__ . "/../";
require_once ROOT . "src/bootstrap.php";
$services = Config::instance()->get("services");


/**
 * @var Handler $handle
 */
try {
	Container::getInstance($services);
	$handle = Container::getInstance()->get(Handler::class);
	$handle->handle();
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
	Divider::printString($e->getMessage());
} catch (InvalidArgumentException $argumentException) {
	Divider::printString($argumentException->getMessage());
}