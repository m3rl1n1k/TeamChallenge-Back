<?php

namespace App\Security;

use App\Repository\User;
use Core\Config;
use Core\Exceptions\BadParameter;
use Core\Http\Request;
use Core\Http\Response;
use Core\Interface\AuthenticateInterface;
use Core\Security\JWToken;
use Core\Security\Password;
use DateTime;
use Exception;
use Firebase\JWT\JWT;
use LogicException;

class Authentication implements AuthenticateInterface
{
	protected array $userCredentials;

	public function __construct(
		protected JWT     $jwt,
		protected JWToken $token,
		protected User    $user,
		protected Request $request
	)
	{
	}

	/**
	 * @throws Exception
	 */
	public function handle($request): string|Response
	{
		$this->userCredentials = $this->user->getUser($request['email']);
		$email = $request['email'];
		$password = $request['password'];
		return $this->credentialsMatch($email, $password);
	}

	/**
	 * @throws Exception
	 */
	protected function credentialsMatch(string $email, string $password)
	{
		$user = $this->user->findBy(['email' => $email]);
		$token = $this->isHasToken();
		if ($user['email'] === $email && Password::decrypt($password, $user['password'])) {
			if ($token) {
				throw new LogicException("You already logged! Your token: $token");
			}
			return $this->onSuccess();
		}
		$this->onFail();
	}

	protected function isHasToken(): string
	{
		return $this->request->getHeader('Authorization');
	}

	/**
	 * @throws Exception
	 */
	protected function onSuccess(): string
	{
		return $this->makeToken();
	}

	/**
	 * @throws Exception
	 */
	private function makeToken(): string
	{
		$payload = [
			"start" => (new DateTime())->getTimestamp(),
			"expired" => (new DateTime("+ " . Config::getValue('middleware.tokenExpTime') . " minute"))->getTimestamp(),
			"user" => $this->userCredentials
		];
		$key = Config::getValue('middleware.token');
		return $this->jwt::encode($payload, $key, 'HS256');
	}

	/**
	 * @throws BadParameter
	 */
	protected function onFail(): void
	{
		throw new BadParameter("Invalid credentials!");
	}
}