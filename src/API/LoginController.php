<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use App\Core\Http\Response;
use App\Security\Authentication\Authentication;
use Exception;


class LoginController extends AbstractController
{

    public function __construct(protected Authentication $authentication)
    {
    }

    /**
     * @throws Exception
     */
    public function auth($request)
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

    public function logout()
    {
        $this->authentication->logout();
    }
}