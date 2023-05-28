<?php


use Bisix21\src\Core\Config;
use Bisix21\src\Core\DI\Container;
use Bisix21\src\UrlShort\Controllers\FrontController;
use Bisix21\src\UrlShort\Services\Printer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

const ROOT = __DIR__ . "/../";
require_once ROOT . "src/bootstrap.php";
$services = Config::instance()->get("services");
try {
	Container::getInstance($services);
	/**
	 * @var FrontController $frontController
	**/
	$frontController = Container::getInstance()->get(FrontController::class);
	$frontController->simpleRoute();
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
	Printer::printString($e->getMessage() . $e->getFile());
} catch (InvalidArgumentException $argumentException) {
	Printer::printStringWithDivider($argumentException->getMessage());
}