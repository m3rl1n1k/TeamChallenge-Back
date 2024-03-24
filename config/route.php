<?php

use App\API\IndexController;
use App\Core\Request;
use App\Core\Route;

$route = new Route();

$route->get('/', IndexController::class, 'index');
$route->get('/product/show/{show}', IndexController::class, 'test');

$route->route(Request::getUrl(), $_POST['_method'] ?? Request::getMethod());


