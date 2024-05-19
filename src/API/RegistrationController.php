<?php

namespace App\API;


use App\Core\Controller\AbstractController;
use App\Security\Register\Register;
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