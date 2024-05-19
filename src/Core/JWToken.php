<?php

namespace App\Core;

use App\Core\Http\HttpStatusCode;
use App\Core\Http\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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
            $key = Config::getValue('config.token');
            $headers = new stdClass();
            $data = JWT::decode($token, new Key($key, 'HS256'), $headers);
            return $this->prepare($data);
        } catch (Exception $e) {
            new Response("Forbidden! Try to login attempt!", HttpStatusCode::FORBIDDEN);
        }
    }

    protected function prepare(stdClass $data): stdClass
    {
        unset($data->password);
        return $data;
    }
}