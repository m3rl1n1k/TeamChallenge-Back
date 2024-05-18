<?php

namespace App\Security\Authentication;

use App\Core\Config;
use App\Core\Http\HttpStatusCode;
use App\Core\Http\Response;
use App\Core\Interface\AuthenticateInterface;
use App\Core\Security\Password;
use App\Repository\User;
use Exception;
use Firebase\JWT\JWT;

class Authentication implements AuthenticateInterface
{
    protected array $userCredentials;

    public function __construct(
        protected JWT  $token,
        protected User $user,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function handle(array $userData): string|Response
    {
        $this->userCredentials = $userData;
        $email = $userData['email'];
        $password = $userData['password'];
        return $this->credentialsMatch($email, $password);
    }

    protected function onSuccess(): string
    {
        $payload = $this->userCredentials;
        $key = Config::getValue('config.token');
        return $this->token::encode($payload, $key, 'HS512');
    }

    protected function onFail(): Response
    {
        return new Response("Invalid credentials!", HttpStatusCode::FORBIDDEN);
    }

    /**
     * @throws Exception
     */
    protected function credentialsMatch(string $email, string $password): string|Response
    {
        $user = $this->user->getUser($email);
        if ($user['email'] === $email && $user['password'] === Password::decrypt($password, $user['password'])) {
            return $this->onSuccess();
        }
        return $this->onFail();
    }
}