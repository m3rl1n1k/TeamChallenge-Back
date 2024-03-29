<?php

use App\API\IndexController;
use App\Core\Container;
use App\Core\Request;
use App\Core\Route;

$route = Container::getInstance()->get(Route::class);

$route->get('/', IndexController::class, 'index');
$route->get('/api/v1/index', IndexController::class, 'index');
$route->get('/api/v1/product/show/{show}', IndexController::class, 'show');
$route->post('/api/v1/product/new', IndexController::class, 'new');

$route->route();


