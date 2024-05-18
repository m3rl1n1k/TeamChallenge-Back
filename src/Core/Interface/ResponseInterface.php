<?php

namespace App\Core\Interface;

interface ResponseInterface
{
    public function setStatusCode(int $code): void;

    public function getStatusCode(): int;

    public function setData($data): static;
}