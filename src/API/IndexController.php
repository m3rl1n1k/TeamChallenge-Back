<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    public function index(): Response
    {
        return $this->json('Use Documentation for API!');
    }
}