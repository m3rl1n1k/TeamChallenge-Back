<?php

namespace App\Core\Controller;

abstract class AbstractController
{
    public function render(string $path): void
    {
        require_once ROOT . 'template' . $path . '.php';
    }
}