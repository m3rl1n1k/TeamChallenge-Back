<?php

use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

//create class in src\Middleware\YourMiddleware
return [
    'token' => base64_encode("M3rl1n1k&Alexandr"),
    'tokenExpTime' => 1, // in minutes
    'middleware' => [
        'admin' => AdminMiddleware::class,
        'auth' => AuthMiddleware::class,
        'guest' => GuestMiddleware::class
    ]
];