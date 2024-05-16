<?php

use App\API\IndexController;
use App\API\LoginController;
use App\API\RegistrationController;
use App\API\ShoesController;
use App\Core\Container\Container;
use App\Core\Route;

/** @var Route $route */
$route = Container::call(Route::class);

$route->get('/', IndexController::class, 'index');
//Security
$route->post('/api/v1/login', LoginController::class, 'auth');
$route->post('/api/v1/registration', RegistrationController::class, 'register');

//shoes
$route->get('/api/v1/product/shoes', ShoesController::class, 'index');
$route->get('/api/v1/product/shoes/show/{show}', ShoesController::class, 'show');
$route->post('/api/v1/product/shoes/new', ShoesController::class, 'new');
$route->put('/api/v1/product/shoes/update/{article}', ShoesController::class, 'update');
$route->delete('/api/v1/product/shoes/delete/{article}', ShoesController::class, 'delete');

//Accessories
$route->get('/api/v1/product/accessories', ShoesController::class, 'index');


$route->route();


