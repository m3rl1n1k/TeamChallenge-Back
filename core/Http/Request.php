<?php

namespace Core\Http;


use Core\Interface\RequestInterface;

class Request implements RequestInterface
{
	private string $uri;
	private string $name;

	public function __construct()
	{
		$this->uri = $_SERVER['REQUEST_URI'];
	}

	public function getUrl(): string
	{
		return $this->convert($this->uri);
	}

	protected function convert($uri, $offset = 0): ?string
	{
		return explode("?", $uri)[$offset];
	}

	public function getMethod(): string
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function getUri(): string
	{
		return $_SERVER['REQUEST_URI'];
	}

	public function getParams(): array
	{
		return $_GET ?? [];
	}

	public function getBody(): false|array|string
	{
		// отримуємо тіло запиту
		return $this->withName()->getContent();
	}

	public function getContent(): array
	{
		$post = $this->getPOST();
		return array_merge(
			!empty($post[$this->name]) ? $post : [],
			$this->getRaw(),
		);
	}

	protected function getPOST(): array
	{
		return [$this->name => $_POST];
	}

	protected function getRaw(): array
	{
		$content = file_get_contents('php://input');
		return $content ? [$this->name => json_decode($content, true)] : [];
	}

	public function withName(string $name = "request"): static
	{
		$this->name = $name;
		return $this;
	}

	public function patternUrl(string $uri, string $pattern = null): ?array
	{

		//якщо урл має патерн {show}
		if (preg_match($pattern ?? '#/{[A-Za-z]+}$#', $uri, $matches)) {
			return $matches;
		}
		return null;
	}

	public function getHeader(string $name): string|Response
	{
		return getallheaders()[$name] ?? new Response("Fail to get header with name $name. Maybe header not be sent!", HttpStatusCode::BAD_REQUEST);
	}

}