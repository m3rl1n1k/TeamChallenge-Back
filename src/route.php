<?php

use App\API\IndexController;
use App\Core\Request;
use App\Core\Route;

$request = Request::getUrl();

$route = new Route();
$route->add('/api/index', IndexController::class, 'index');
$route->add('/test', IndexController::class, 'index');

$route->route($request);


