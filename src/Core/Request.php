<?php

namespace App\Core;

class Request
{
	protected array $get;
	
	public function __construct()
	{
		$this->get = $_GET;
	}
	
	public static function getId(): string
	{
		$result = (new Request())->getRequestUrl();
		$pattern = '{/[A-Za-z]+/\d}';
		if (preg_match($pattern, $result, $matches)){
			return explode('/', $matches[0])[2];
		}
		return "";
	}
	
	public function getDataFromGetRequest(): array
	{
		return $this->get;
	}
	
	public function getRequestUrl(): string
	{
		return $this->convert($_SERVER['REQUEST_URI']);
	}
	public function getRequestMethod(): string
	{
		return $_SERVER['REQUEST_METHOD'];
	}
	
	protected function convert($uri): string
	{
		return explode("?", $uri)[0];
	}
	
	public static function getUrl(): string
	{
		return (new Request)->getRequestUrl();
	}
	
	public static function getMethod(): string
	{
		return (new Request)->getRequestMethod();
	}
}