<?php

namespace App\Core\Interface;

interface SessionInterface
{
    public function getSession(): mixed;

    public function addToSession(string $key, mixed $value): void;

    public function removeFromSession(string $key): void;

    public function getFromSession(string $key): mixed;
}