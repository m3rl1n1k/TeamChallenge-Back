<?php

namespace App\Core\Interface;

interface ResponseInterface
{
    public function setHeader(string $header, mixed $value): static;

    public function setStatusCode(int $code): void;

    public function getStatusCode(): int;

    public function setData($data): static;

    public function getHeader(): array;


    public function send();
}