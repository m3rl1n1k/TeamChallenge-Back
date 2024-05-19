<?php

use App\Middleware\Admin;
use App\Middleware\Auth;
use App\Middleware\Guest;

return [
    'admin' => Admin::class,
    'auth' => Auth::class,
    'guest' => Guest::class
];