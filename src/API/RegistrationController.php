<?php

namespace App\API;

use App\Auth\Register\Register;
use App\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends AbstractController
{
    public function __construct(protected Register $register)
    {
    }

    public function register($request): Response
    {
        $this->register->handle($request);
        return $this->json('You registered!');
    }
}