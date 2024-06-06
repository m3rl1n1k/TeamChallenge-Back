<?php

use App\API\IndexController;
use App\API\LoginController;
use App\API\RegistrationController;
use App\API\ShoesController;
use App\Core\Container\Container;
use App\Core\Route\Route;

/** @var Route $route */
$route = Container::call(Route::class);

$route->get('/', IndexController::class, 'index');
//Security
$route->post('/api/v1/login', LoginController::class, 'auth');
$route->get('/api/v1/logout', LoginController::class, 'logout');
$route->post('/api/v1/registration', RegistrationController::class, 'register');

//shoes
$route->get('/api/v1/product/shoes', ShoesController::class, 'index');
$route->post('/api/v1/product/shoes', ShoesController::class, 'new')->only('admin');
$route->get('/api/v1/product/shoes/{article}', ShoesController::class, 'show');
$route->put('/api/v1/product/shoes/{article}', ShoesController::class, 'update')->only('admin');
$route->delete('/api/v1/product/shoes/{article}', ShoesController::class, 'delete')->only('admin');

//Accessories
$route->get('/api/v1/product/accessories', ShoesController::class, 'index')->only('auth');


$route->route();


