<?php

namespace App\Core\Security;

use App\Core\Config;
use App\Core\Http\HttpStatusCode;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Session;
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

    public function decode()
    {
        $token = $this->request->getRequestHeader('Authorization');
        if (empty($token)) {
            new Response("Forbidden!", HttpStatusCode::FORBIDDEN);
        }
        try {
            $key = Config::getValue('middleware.token');
            $headers = new stdClass();
            $data = JWT::decode($token, new Key($key, 'HS256'), $headers);
            return $this->prepare($data);
        } catch (Exception $e) {
            new Response("Forbidden! Try to login attempt! {$e->getMessage()}", HttpStatusCode::FORBIDDEN);
        }
    }

    protected function prepare(stdClass $data): stdClass
    {
        $timeNow = new DateTime();
        if ($data->expired < $timeNow->getTimestamp()) {
            Session::remove('token');
            throw new LogicException('Token is not valid');
        }
        unset($data->password);
        return $data;
    }
}