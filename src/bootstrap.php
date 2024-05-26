<?php

use App\Core\Config;
use App\Core\Container\Container;
use App\Core\Controller\ExceptionController;
use App\Core\Session;

require_once "../vendor/autoload.php";

//Session::sessionStart();

/** @var ExceptionController $eHandler */
Container::call(ExceptionController::class);
// map configs
Config::instance(
    array_merge(
        [
            'database' => require_once "../config/database.php",
            'config' => require "../config/config.php",
            'headers' => require "../config/headers.php",
            'middleware' => require "../config/middleware.php",
        ]
    )
);