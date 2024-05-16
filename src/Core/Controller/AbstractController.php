<?php

namespace App\Core\Controller;

use App\Core\Container\Container;
use App\Core\Exceptions\NotSendHeaders;
use App\Core\Security\Response;

class AbstractController
{
    protected Response $response;

    protected function prepare(): void
    {
        $this->response = Container::call(Response::class);
    }

    public function response($data, int $statusCode): void
    {
        $this->prepare();

        $this->response->setHeader('Content-Type', 'application/json');
        $this->response->setData($data);
        $this->response->setStatusCode($statusCode);
        $this->response->send();
        echo $this->response->response();
    }

    public function render(string $path): void
    {
        require_once ROOT . 'template' . $path . '.php';
    }
}