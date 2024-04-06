<?php

namespace App\Core;

class Redirect
{

    public static function route($path = "/"): void
    {
        header("Location: http://localhost:8080/api/v1$path");
    }
}