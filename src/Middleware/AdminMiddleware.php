<?php

namespace App\Middleware;

use App\Core\Http\HttpStatusCode;
use App\Core\Http\Response;
use App\Core\Interface\MiddlewareInterface;
use App\Core\JWToken;
use App\Repository\User;

class AdminMiddleware implements MiddlewareInterface
{

    public function __construct(protected JWToken $JWToken, protected User $user)
    {
    }

    public function handler(): void
    {
        $data = $this->JWToken->decode();
        $user = $this->user->getUser($data->email);
        $user['role'] = json_decode($user['role']);
        if (!in_array("ADMIN_ROLE", $user['role']))
            new Response("You don't have access to this page!", HttpStatusCode::FORBIDDEN);


    }
}