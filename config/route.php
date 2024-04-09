<?php

use App\API\IndexController;
use App\API\LoginController;
use App\API\ProductController;
use App\API\RegistrationController;
use App\Core\Container\Container;
use App\Core\Route;

/** @var Route $route */
$route = Container::getInstance()->get(Route::class);

$route->get('/', IndexController::class, 'index');
//Auth
$route->post('/api/v1/login', LoginController::class, 'auth');
$route->post('/api/v1/registration', RegistrationController::class, 'register');
//Product
$route->get('/api/v1/products/index', ProductController::class, 'index');
$route->get('/api/v1/product/show/{show}', ProductController::class, 'show');
$route->post('/api/v1/product/new', ProductController::class, 'new');


$route->route();


