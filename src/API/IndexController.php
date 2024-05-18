<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use App\Core\Http\Response;

class IndexController extends AbstractController
{
    public function index()
    {
        new Response('Use Documentation for API!');
    }
}