<?php

namespace App\Auth\Authentication;

use App\Core\Config;
use App\Core\Header;
use App\Core\Interface\AuthenticateInterface;
use App\Core\Security\Password;
use App\Repository\User;
use Exception;
use Firebase\JWT\JWT;

class Authentication implements AuthenticateInterface
{
    protected array $userCredentials;

    public function __construct(
        protected JWT    $token,
        protected User   $user,
        protected Header $header
    )
    {
    }

    /**
     * @throws Exception
     */
    public function handle(array $userData): void
    {
        $this->userCredentials = $userData;
        $email = $userData['email'];
        $password = $userData['password'];
        $this->credentialsMatch($email, $password) ? $this->onSuccess() : $this->onFail();
    }

    protected function onSuccess(): void
    {
        $payload = $this->userCredentials;
        $key = Config::getValue('config.token');
        $token = $this->token::encode($payload, $key, 'HS512');
        $this->header->sendContent($token);
    }

    /**
     * @throws Exception
     */
    protected function onFail()
    {
        throw new Exception('Auth is failed!');
    }

    /**
     * @throws Exception
     */
    protected function credentialsMatch(string $email, string $password): bool
    {
        $user = $this->user->get($email);
        if ($user['email'] === $email && $user['password'] == Password::decrypt($password, $user['password'])) {
            return true;
        }
        return false;
    }
}