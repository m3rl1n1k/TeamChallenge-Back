<?php

use App\API\IndexController;
use App\API\ProductController;
use App\Core\Container;
use App\Core\Route;

$route = Container::getInstance()->get(Route::class);

$route->get('/', IndexController::class, 'index');
$route->get('/api/v1/index', ProductController::class, 'index');
$route->get('/api/v1/product/show/{show}', ProductController::class, 'show');
$route->post('/api/v1/product/new', ProductController::class, 'new');

$route->route();


