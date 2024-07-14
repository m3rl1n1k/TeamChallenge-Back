<?php

namespace App\Security;

use App\Repository\UserRepository;
use Core\Http\HttpStatusCode;
use Core\Http\Response;
use Core\Interface\AuthenticateInterface;
use Core\Security\Password;
use Exception;
use LogicException;

class Register implements AuthenticateInterface
{
    public function __construct(
        protected UserRepository $user
    )
    {
    }

    /**
     * @throws Exception
     */
    public function handle($request): void
    {
        if ($request['password'] !== $request['re-password']) {
            throw new LogicException("Passwords not matches!");
        }
        $request['password'] = Password::encrypt($request['password']);
        unset($request['re-password']);
        $result = false; //$this->user->newUser($request);
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