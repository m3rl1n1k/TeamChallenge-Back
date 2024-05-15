<?php

namespace App\API;

use App\Auth\Authentication\Authentication;
use App\Core\Controller\AbstractController;
use Exception;
use Symfony\Component\HttpFoundation\Response;

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
        return $this->response($msg);
    }
}