<?php

use App\Core\Config;
use App\Core\Container\Container;
use App\Core\Controller\ExceptionController;
use App\Core\Session;

require_once ROOT . "vendor/autoload.php";

Session::sessionStart();

/** @var \App\Core\Controller\ExceptionController $eHandler */
Container::call(ExceptionController::class);
// map configs
Config::instance(
    array_merge(
        [
            'database' => require_once ROOT . "config/database.php",
            'config' => require ROOT . "/config/config.php",
            'headers' => require ROOT . "/config/headers.php",
            'middleware' => require ROOT . "/config/middleware.php",
        ]
    )
);