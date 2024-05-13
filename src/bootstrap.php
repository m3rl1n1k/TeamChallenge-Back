<?php

use App\Core\Config;

require_once ROOT . "vendor/autoload.php";

Config::instance(
    array_merge(
        [
            'database' => require_once ROOT . "config/database.php",
            'config' => require ROOT . "/config/config.php"
        ]
    )
);
function mode($exception): void
{
    $res = match (Config::getValue('config.mode')) {
        'dev' => $exception->getMessage() . " " . $exception->getLine() . " " . $exception->getFile(),
        'prod' => $exception->getMessage(),
    };
    echo $res;
}