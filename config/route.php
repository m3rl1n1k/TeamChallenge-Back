<?php

use App\API\IndexController;
use App\Core\Request;
use App\Core\Route;

$route = new Route();

$route->get('/', IndexController::class, 'index');
$route->get('/test', IndexController::class, 'test');
$route->get('/product/show/{id}', IndexController::class, 'index')->addArgs('id', Request::getId());

$route->route(Request::getUrl(), $_POST['_method'] ?? Request::getMethod());


