<?php

use Core\Route\Route;

error_reporting(E_ERROR);
const ROOT = __DIR__ . "/../";
require_once ROOT . 'src/bootstrap.php';

/** @var Route $route */
Route::configRoute();
