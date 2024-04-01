<?php

namespace App\Core\Controller;

use JetBrains\PhpStorm\NoReturn;

class Helper
{
    #[NoReturn] public static function printError($msg, ...$value): void
    {
        printf($msg, ...$value);
        exit();
    }
}