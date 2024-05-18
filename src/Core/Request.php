<?php

namespace App\Core;


use App\Core\Http\HttpStatusCode;
use App\Core\Http\Response;
use App\Core\Interface\RequestInterface;

class Request implements RequestInterface
{
    private string $uri;

    public function __construct()
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
        return $_GET ? ['params' => $_GET] : [];
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

    public function withName(string $name = "request"): static
    {
        $this->name = $name;
        return $this;
    }

    public function getRequestBody(): false|array|string
    {
        // отримуємо тіло запиту
        return $this->withName()->getContent();
    }

    public function isPatternUri(string $uri, string $pattern = null): ?array
    {

        //якщо урл має патерн {show}
        if (preg_match($pattern ?? '#/{[A-Za-z]+}$#', $uri, $matches)) {
            return $matches;
        }
        return null;
    }

    public function getRequestHeader(string $name): string|Response
    {
        return getallheaders()[$name] ?? new Response("Fail to get header with name $name. Maybe header not be sent!", HttpStatusCode::BAD_REQUEST);
    }

}