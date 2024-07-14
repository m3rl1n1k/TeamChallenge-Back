<?php

namespace Core\Security;

use Core\Config;
use Core\Http\HttpStatusCode;
use Core\Http\Request;
use Core\Http\Response;
use DateTime;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LogicException;
use stdClass;

class JWToken
{
	public function __construct(protected Request $request)
	{
	}

	public function decode(): false|stdClass
	{
		$token = $this->request->getHeader('Authorization');
		if (empty($token)) {
			new Response("Forbidden!", HttpStatusCode::FORBIDDEN);
		}
		try {
			$key = Config::getValue('middleware.token');
			$headers = new stdClass();
			$data = JWT::decode($token, new Key($key, 'HS256'), $headers);
			return $this->timeExpiredVerify($data);
		} catch (Exception $e) {
			new Response("Try to login attempt! {$e->getMessage()}", HttpStatusCode::FORBIDDEN);
			return false;
		}
	}

	protected function timeExpiredVerify(stdClass $token): stdClass
	{
		$timeNow = new DateTime();
		if ($token->expired < $timeNow->getTimestamp()) {
			throw new LogicException('Token is not valid');
		}
		unset($token->password);
		return $token;
	}
}