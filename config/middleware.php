<?php

use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

//create class in src\Middleware\YourMiddleware
return [
    'admin' => AdminMiddleware::class,
    'auth' => AuthMiddleware::class,
    'guest' => GuestMiddleware::class
];