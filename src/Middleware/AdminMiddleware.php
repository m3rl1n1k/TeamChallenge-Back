<?php

namespace App\Middleware;

use App\Repository\User;
use Core\Http\HttpStatusCode;
use Core\Http\Response;
use Core\Interface\MiddlewareInterface;
use Core\Security\JWToken;
use Exception;

class AdminMiddleware implements MiddlewareInterface
{

	protected array $user;

	public function __construct(protected JWToken $JWToken, protected User $userRepository)
	{
	}

	/**
	 * @throws Exception
	 */
	public function handler(): void
	{
		$token = $this->JWToken->decode();//decode token
		$this->user = $this->userRepository->getUser($token->user->email);//check user in DB

		$this->user['role'] = json_decode($this->user['role'], true);// decode roles to array

		if (!$this->hasRole('ADMIN_ROLE')) // check that user have role
			new Response("You don't have access to this page!", HttpStatusCode::FORBIDDEN);

	}

	protected function hasRole(string $role): bool
	{
		return in_array($role, $this->user['role']);
	}
}