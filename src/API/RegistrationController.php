<?php

namespace App\API;


use App\Security\Register;
use Core\Controller\AbstractController;
use Exception;

class RegistrationController extends AbstractController
{
	public function __construct(protected Register $register)
	{
	}

	/**
	 * @throws Exception
	 */
	public function register($request): void
	{
		$this->register->handle($request);
	}
}