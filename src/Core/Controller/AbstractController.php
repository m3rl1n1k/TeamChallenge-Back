<?php

namespace App\Core\Controller;

use App\Core\Container\Container;
use App\Core\Http\Header;
use App\Core\Http\Response;
use App\Core\HttpStatusCode;

abstract class AbstractController
{
    public function render(string $path): void
    {
        require_once ROOT . 'template' . $path . '.php';
    }
}