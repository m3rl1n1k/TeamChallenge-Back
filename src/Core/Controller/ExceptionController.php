<?php

namespace App\Core\Controller;

use App\Core\Config;
use App\Core\Exceptions\NotSendHeaders;
use App\Core\Http\HttpStatusCode;
use App\Core\Http\Response;
use Throwable;

class ExceptionController extends AbstractController
{
    public function __construct()
    {
        @set_exception_handler(array($this, 'handler'));
    }

    /**
     * @throws NotSendHeaders
     */
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