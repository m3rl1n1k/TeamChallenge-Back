<?php

namespace App\API;

use App\Security\Authentication;
use Core\Controller\AbstractController;
use Core\Http\Response;
use Exception;


class LoginController extends AbstractController
{

	public function __construct(protected Authentication $authentication)
	{
	}

	/**
	 * @throws Exception
	 */
	public function auth($request): Response
	{
		$msg = [];
		$token = $this->authentication->handle($request);
		if ($token) {
			$msg['token'] = $token;
		} else {
			$msg['failed'] = 'Security is failed!';
		}
		return new Response($msg);
	}

	public function logout(): void
	{
		$this->authentication->logout();
	}
}