<?php

use Psr\Container\ContainerExceptionInterface;

error_reporting(E_ERROR);
const ROOT = __DIR__ . "/../";
require_once ROOT . 'src/bootstrap.php';
try {
    require_once ROOT . 'config/route.php';
} catch (Exception|ContainerExceptionInterface|Error $e) {
    echo $e->getMessage() . " " . $e->getLine() . " " . $e->getFile() . " " . "</b>";
}