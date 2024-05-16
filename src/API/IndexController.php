<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use App\Core\HttpStatusCode;

class IndexController extends AbstractController
{
    public function index()
    {
        $this->response('Use Documentation for API!', HttpStatusCode::OK);
    }
}