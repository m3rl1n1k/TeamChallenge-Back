<?php

namespace App\Auth\Register;

use App\Core\Config;
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
        $password = $userData['password'];
        $userData['password'] = Password::encrypt($password);
        Config::instance()->set($userIdentification, $userData);
    }
}