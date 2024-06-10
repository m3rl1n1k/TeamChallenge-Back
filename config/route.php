<?php

use App\API\IndexController;
use App\API\LoginController;
use App\API\OrderController;
use App\API\ProductController;
use App\API\RegistrationController;
use Core\Container\Container;
use Core\Route\Route;

/** @var Route $route */
$route = Container::call(Route::class);

$route->get('/', IndexController::class, 'index');
//Security
$route->post('/api/v1/login', LoginController::class, 'auth');
$route->post('/api/v1/registration', RegistrationController::class, 'register');

//Product
$route->get('/api/v1/products', ProductController::class, 'index')->params();
$route->post('/api/v1/product', ProductController::class, 'new')->only('admin');
$route->get('/api/v1/product/{article}', ProductController::class, 'show');
$route->put('/api/v1/product/{article}', ProductController::class, 'update')->only('admin');
$route->delete('/api/v1/product/{article}', ProductController::class, 'delete')->only('admin');

//Order
$route->post('/api/v1/order/create', OrderController::class, 'createOrder');


$route->route();


