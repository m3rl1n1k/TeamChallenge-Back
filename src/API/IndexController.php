<?php

namespace App\API;

use App\Core\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    public function index(): Response
    {
        return $this->json('Use Documentation for API!');
    }

}