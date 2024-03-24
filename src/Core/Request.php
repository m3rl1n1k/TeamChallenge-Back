<?php

namespace App\Core;

class Request
{
	protected array $get;
	
	public function __construct()
	{
		$this->get = $_GET;
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