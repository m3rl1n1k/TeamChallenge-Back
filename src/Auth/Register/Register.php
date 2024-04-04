<?php

namespace App\Auth\Register;

use App\BIN\Database;
use App\Core\ConnectionDB;
use App\Core\Interface\AuthenticateInterface;
use App\Core\Security\Password;
use Override;

class Register implements AuthenticateInterface
{
    public function __construct()
    {
    }

    #[Override] public function handle(array $userData): void
    {
        $userIdentification = $userData['email'];
        $password = Password::encrypt($userData['password']);
        $name = $userData['name'];
        Database::connect()->query("INSERT INTO user (email, password, name) VALUES ($userIdentification, $password, $name)");
    }
}