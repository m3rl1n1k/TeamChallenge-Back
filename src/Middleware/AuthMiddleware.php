<?php

namespace App\Middleware;

use App\Core\Exceptions\NotSendHeaders;
use App\Core\Http\Response;
use App\Core\Interface\MiddlewareInterface;
use App\Core\JWToken;
use App\Repository\User;


class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(protected JWToken $JWToken, protected User $user)
    {
    }

    /**
     * @throws NotSendHeaders
     */
    public function handler(): void
    {
        $data = $this->JWToken->decode();
        $user = $this->user->getUser($data->email);
        new Response($user);

    }
}