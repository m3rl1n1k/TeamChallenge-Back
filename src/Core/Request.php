<?php

namespace App\Core;


use App\Core\Interface\RequestInterface;

class Request implements RequestInterface
{

    private string $name;

    protected function convert($uri): string
    {
        return explode("?", $uri)[0];
    }

    public function getUrl(): string
    {
        return $this->convert($_SERVER['REQUEST_URI']);
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getContent($raw = false): false|array|string
    {
        $content = file_get_contents('php://input');
        if ($raw) {
            return $content;
        }
        return $content ? [$this->name => json_decode($content, true)] : [];
    }

    public function withName(string $name): static
    {
        $this->name = $name;
        return $this;
    }
}