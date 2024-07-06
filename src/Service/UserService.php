<?php

namespace App\Service;


use App\Repository\UserRepository;
use Core\Security\JWToken;
use Exception;

class UserService
{
	public function __construct(protected UserRepository $userRepository, protected JWToken $JWToken)
	{
	}

	/**
	 * @throws Exception
	 */
	public function getUser()
	{
		$token = $this->JWToken->decode();//decode token
		$user = $this->userRepository->getUser($token->user->email);

		return $user;
	}
}