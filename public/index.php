<?php

use App\Core\Container;
use App\Core\Handler;
use DiggPHP\Psr11\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

const ROOT = __DIR__ . "/../";
require_once ROOT . 'src/bootstrap.php';
try {
	Container::getInstance()->get(Handler::class)->handle();
} catch (Exception|ContainerExceptionInterface $e) {
	echo $e->getMessage();
}