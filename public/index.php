<?php

use App\Core\Container;
use App\Core\Handler;
use DiggPHP\Psr11\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

error_reporting(E_ERROR);
const ROOT = __DIR__ . "/../";
require_once ROOT . 'src/bootstrap.php';
try {
	require_once ROOT . 'config/route.php';
	Container::getInstance()->get(Handler::class)->handle();
} catch (Exception|ContainerExceptionInterface|Error $e) {
	echo "<b>" . $e->getMessage() . "</b>, line <b>" . $e->getLine() . "</b>, in File <b>" . $e->getFile() . "</b>";
}