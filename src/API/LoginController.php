<?php

namespace App\API;

use App\Auth\Authentication\Authentication;
use App\Core\Controller\AbstractController;
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
        $this->authentication->handle($request);
    }
}