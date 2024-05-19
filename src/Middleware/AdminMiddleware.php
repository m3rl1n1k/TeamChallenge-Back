<?php

namespace App\Middleware;

use App\Core\Http\HttpStatusCode;
use App\Core\Http\Response;
use App\Core\Interface\MiddlewareInterface;
use App\Core\Security\JWToken;
use App\Repository\User;

class AdminMiddleware implements MiddlewareInterface
{

    public function __construct(protected JWToken $JWToken, protected User $user)
    {
    }

    public function handler(): void
    {
        $data = $this->JWToken->decode();//decode token
        $user = $this->user->getUser($data->user->email); //check user in DB
        $user['role'] = json_decode($user['role']);// decode roles to array
        if (!in_array("ADMIN_ROLE", $user['role'])) // check that user have role
            new Response("You don't have access to this page!", HttpStatusCode::FORBIDDEN);


    }
}