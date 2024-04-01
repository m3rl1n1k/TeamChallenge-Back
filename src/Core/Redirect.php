<?php

namespace App\Core;

class Redirect
{

    public static function route($path = "/"): void
    {
        header("Location: $path");
    }
}