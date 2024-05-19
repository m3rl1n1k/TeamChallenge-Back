<?php

namespace App\Security\Register;

use App\Core\Http\HttpStatusCode;
use App\Core\Http\Response;
use App\Core\Interface\AuthenticateInterface;
use App\Core\Security\Password;
use App\Repository\User;
use Exception;
use LogicException;

class Register implements AuthenticateInterface
{
    public function __construct(
        protected User $user
    )
    {
    }

    /**
     * @throws Exception
     */
    public function handle(array $userData): void
    {
        if ($userData['password'] !== $userData['re-password']) {
            throw new LogicException("Passwords not matches!");
        }
        $userData['password'] = Password::encrypt($userData['password']);
        unset($userData['re-password']);
        $result = $this->user->newUser($userData);
        $result ? $this->onSuccess() : $this->onFail();
    }

    /**
     * @throws Exception
     */
    protected function onSuccess(): void
    {
        new Response("Register successfully!", HttpStatusCode::CREATED);
    }

    /**
     * @throws Exception
     */
    protected function onFail()
    {
        throw new Exception('Register is failed!', HttpStatusCode::BAD_REQUEST);
    }


}