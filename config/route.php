<?php

use App\API\IndexController;
use App\API\LoginController;
use App\API\ProductController;
use App\API\RegistrationController;
use App\API\ShoesController;
use App\Core\Container\Container;
use App\Core\Route;

/** @var Route $route */
$route = Container::getInstance()->get(Route::class);

$route->get('/', IndexController::class, 'index');
//Auth
$route->post('/api/v1/login', LoginController::class, 'auth');
$route->post('/api/v1/registration', RegistrationController::class, 'register');
//shoes
$route->get('/api/v1/product/shoes', ShoesController::class, 'index');
$route->get('/api/v1/product/shoes/show/{show}', ShoesController::class, 'show');
//sweats
$route->get('/api/v1/product/sweats/show/{show}', ProductController::class, 'show');

$route->post('/api/v1/product/new/{type}', ProductController::class, 'new');


$route->route();


