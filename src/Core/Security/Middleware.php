<?php

namespace App\Core\Security;

use App\Core\Config;
use App\Core\Header;
use App\Core\Request;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Response;

class Middleware
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Closure $next)
    {
        $token = $this->request->bearerToken();

        if (!$token) {
            // todo return $this->header->sendResponse("Forbidden!", Response::HTTP_FORBIDDEN);
        }

        try {
            $key = Config::getValue('config.token');
//            $headers = ['HS512'];
            $decoded = JWT::decode($token, $key);

            // Перевірка дозволів користувача, наприклад, ролей або інших атрибутів токену
            // Якщо дозволи відповідають очікуваним, можна продовжити обробку запиту
        } catch (Exception $e) {
            return $this->header->sendResponse(['error' => 'Unauthorized'], 401);
        }

        return $next($this->request);
    }
}