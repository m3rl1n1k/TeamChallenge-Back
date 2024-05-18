<?php

use App\API\ExceptionController;
use App\Core\Config;
use App\Core\Container\Container;

require_once ROOT . "vendor/autoload.php";
/** @var ExceptionController $eHandler */
Container::call(ExceptionController::class);
// map configs
Config::instance(
    array_merge(
        [
            'database' => require_once ROOT . "config/database.php",
            'config' => require ROOT . "/config/config.php",
            'headers' => require ROOT . "/config/headers.php"
        ]
    )
);
// check set mode
//function mode($exception): void
//{
//    $res = match (Config::getValue('config.mode')) {
//        'dev' => $exception->getMessage() . " " . $exception->getLine() . " " . $exception->getFile(),
//        'prod' => $exception->getMessage(),
//    };
//    echo $res;
//}