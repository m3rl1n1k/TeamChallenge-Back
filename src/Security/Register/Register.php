<?php

namespace App\Auth\Register;

use App\Core\Interface\AuthenticateInterface;
use App\Repository\User;
use Exception;

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
            $this->onSuccess($userData) ?? $this->onFail();
    }

    /**
     * @throws Exception
     */
    protected function onSuccess(array $userData): string
    {
        if ($this->user->setUser($userData)) {
            return "Successfully registered";
        }
        return $this->onFail();
    }

    /**
     * @throws Exception
     */
    protected function onFail()
    {
        throw new Exception('Register is failed!');
    }


}