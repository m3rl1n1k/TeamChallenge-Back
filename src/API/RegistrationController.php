<?php

namespace App\API;

use App\Auth\Register\Register;
use App\Core\Controller\AbstractController;
use Exception;
use Symfony\Component\HttpFoundation\Response;

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