<?php

use App\API\IndexController;
use App\Core\Request;
use App\Core\Route;

$route = new Route();

$route->get('/', IndexController::class, 'index');
$route->get('/api/v1/index', IndexController::class, 'index');
$route->post('/api/v1/product/new', IndexController::class, 'new');
$route->get('/api/v1/product/show/{show}', IndexController::class, 'show');
$route->get('/api/v1/products', IndexController::class, 'show');

$route->route(Request::getUrl(), $_POST['_method'] ?? Request::getMethod());


