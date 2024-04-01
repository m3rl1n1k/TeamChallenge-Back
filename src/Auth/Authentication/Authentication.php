<?php

namespace App\Auth\Authentication;

use App\Core\Config;
use App\Core\Interface\AuthenticateInterface;
use App\Core\Redirect;
use App\Core\Security\Password;
use App\Core\Session;
use Exception;
use Override;

class Authentication implements AuthenticateInterface
{
    public function __construct(protected Session $session)
    {
    }

    /**
     * @throws Exception
     */
    #[Override] public function handle(array $userData): void
    {
        $userIdentification = $userData['email'];
        $password = $userData['password'];
        $this->credentialsMatch($userIdentification, $password) ? $this->onSuccess() : $this->onFail();
    }

    protected function onSuccess(): void
    {
        echo "Login success!";
    }

    /**
     * @throws Exception
     */
    protected function onFail()
    {
        throw new Exception('Auth is failed!');
    }

    protected function credentialsMatch(string $userIdentification, string $password): bool
    {
        //todo Change user provider
        $user = "";
        if ($user['userIdentification'] === $userIdentification && $user['password'] === Password::decrypt($password, $user['password'])) {
            return true;
        }
        return false;
    }
}