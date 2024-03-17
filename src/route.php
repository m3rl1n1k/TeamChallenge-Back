<?php

use App\API\IndexController;
use App\Core\Request;
use App\Core\Route;

$request = Request::getUrl();

$route = new Route();
$route->add('/', IndexController::class, 'index');
$route->add('/test', IndexController::class, 'show');

$route->route($request);


