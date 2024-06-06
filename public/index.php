<?php

use App\Core\Route\Route;

error_reporting(E_ERROR);
const ROOT = __DIR__ . "/../";
require_once ROOT . 'src/bootstrap.php';


/** @var \App\Core\Route\Route $route */
Route::configRoute();
