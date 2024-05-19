<?php

namespace App\Security\Authentication;

use App\Core\Config;
use App\Core\Exceptions\BadParameter;
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
        return $this->token::encode($payload, $key, 'HS256');
    }

    protected function onFail(): void
    {
        throw new BadParameter("Invalid credentials!");
    }

    /**
     * @throws Exception
     */
    protected function credentialsMatch(string $email, string $password)
    {
        $user = $this->user->findBy(['email' => $email]);
        if ($user['email'] === $email && Password::decrypt($password, $user['password'])) {
            return $this->onSuccess();
        }
        $this->onFail();
    }
}