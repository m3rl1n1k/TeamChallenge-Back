<?php

namespace App\API;

use App\Core\Config;
use App\Core\Controller\AbstractController;
use App\Core\Http\Response;
use App\Core\HttpStatusCode;
use Throwable;

class ExceptionController extends AbstractController
{
    public function __construct()
    {
        @set_exception_handler(array($this, 'handler'));
    }

    public function handler(Throwable $e): Response
    {
        return new Response($this->mode($e), HttpStatusCode::BAD_REQUEST);
    }

    protected function mode($e)
    {
        return match (Config::getValue('config.mode')) {
            'dev' => $e->getMessage() . " " . $e->getLine() . " " . $e->getFile(),
            'prod' => $e->getMessage(),
        };
    }
}