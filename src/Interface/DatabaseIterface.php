<?php

namespace App\Interface;

interface DatabaseIterface
{
    public function connect(): void;

    public function save(): void;

    public function read(): mixed;
}