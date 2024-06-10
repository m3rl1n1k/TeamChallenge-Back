<?php

namespace App\Middleware;

use App\Repository\User;
use Core\Exceptions\NotSendHeaders;
use Core\Http\Response;
use Core\Interface\MiddlewareInterface;
use Core\Security\JWToken;


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