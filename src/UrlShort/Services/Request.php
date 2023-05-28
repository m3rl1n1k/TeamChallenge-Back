<?php

namespace Bisix21\src\UrlShort\Services;

class Request
{
	protected array $get;

	public function __construct()
	{
		$this->get = $_GET;
	}

	public function getDataFromGetRequest(): array
	{
		return $this->get;
	}

	public function getRequestUrl(): string
	{
		return $this->convert($_SERVER['REQUEST_URI']);
	}

	protected function convert($uri): string
	{
		return explode("?", $uri)[0];
	}
}