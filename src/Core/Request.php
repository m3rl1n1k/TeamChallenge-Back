<?php

namespace App\Core;


class Request
{

    private string $name;

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
	public function getContent($raw = false): false|array|string
	{
		$content = file_get_contents('php://input');
		if ($raw){
			return  $content;
		}
		return $content ? [$this->name => json_decode($content, true)] : [];
	}

    public function withName(string $name): static
    {
        $this->name = $name;
        return $this;
    }
}