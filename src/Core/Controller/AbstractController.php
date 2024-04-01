<?php

namespace App\Core\Controller;

use App\Core\Container\Container;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    protected mixed $response;

    protected function Response(): void
    {
        $this->response = Container::getInstance()->get(Response::class);
    }

    public function json($data, $format = 'json'): Response
    {
        $this->Response();
        if ($format === 'json') {
            $json = json_encode($data);
            $this->headers($json);
        }
        if ($format === 'array') {
            return json_decode($data, true);
        }
        return new Response();
    }

    protected function headers($content): void
    {
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->headers->set('Access-Control-Allow-Origin', '*');
        $this->response->setContent($content);
        $this->response->send();
    }

    public function render(string $path): Response
    {
        require_once ROOT . 'template' . $path . '.php';
        return $this->response;
    }
}