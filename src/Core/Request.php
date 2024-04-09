<?php

namespace App\Core;


use App\Core\Interface\RequestInterface;

class Request implements RequestInterface
{
    private string $uri;

    public function __construct(protected Header $header)
    {
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    private string $name;

    protected function convert($uri, $offset = 0): ?string
    {
        return explode("?", $uri)[$offset];
    }

    public function getUrl(): string
    {
        return $this->convert($this->uri);
    }

    public function getParams(): array
    {
        $paramsList = [];
        $params = $this->convert($this->uri, 1);
        if ($params === null) {
            return [];
        }
        $params = explode('&', $params);
        foreach ($params as $param) {
            $param = explode('=', $param);
            $paramsList[$param[0]] = $param[1];
        }
        return ['params' => $paramsList];

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

    public function bearerToken(): ?string
    {
        return $this->header->getHeader('Authorization');
    }
}