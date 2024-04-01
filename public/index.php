<?php

use App\Core\Route;

error_reporting(E_ERROR);
const ROOT = __DIR__ . "/../";
require_once ROOT . 'src/bootstrap.php';

try {
    /** @var Route $route */
    Route::configRoute();
} catch (Exception|Error $e) {
    echo $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
}