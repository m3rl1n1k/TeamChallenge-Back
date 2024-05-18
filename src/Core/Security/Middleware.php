<?php

namespace App\Core\Security;

use App\Core\Config;
use App\Core\Http\HttpStatusCode;
use App\Core\Http\Response;
use App\Core\Request;
use Exception;
use Firebase\JWT\JWT;
use stdClass;

class Middleware
{
    public function __construct(protected Request $request)
    {
    }

    public function handler()
    {
        $token = $this->request->getRequestHeader('Authorization');
        if (empty($token)) {
            return new Response("Forbidden!", HttpStatusCode::FORBIDDEN);
        }
        try {
            $key = Config::getValue('config.token');
            $headers = new stdClass();
            $decoded = JWT::decode($token, $key, $headers);
            dd($key, $headers, $decoded);
            // Перевірка дозволів користувача, наприклад, ролей або інших атрибутів токену
            // Якщо дозволи відповідають очікуваним, можна продовжити обробку запиту
        } catch (Exception $e) {
            new Response("Forbidden! {$e->getMessage()} {$e->getFile()}", HttpStatusCode::FORBIDDEN);
            exit();
        }

        return $next();
    }
}