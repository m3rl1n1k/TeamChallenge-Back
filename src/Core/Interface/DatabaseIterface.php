<?php

namespace App\Core\Interface;

interface DatabaseIterface
{
    public function connect(): void;

    public function save(): void;

    public function read(): mixed;
}