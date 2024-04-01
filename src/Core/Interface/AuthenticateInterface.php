<?php

namespace App\Core\Interface;

interface AuthenticateInterface
{
    public function handle(array $userData);
}