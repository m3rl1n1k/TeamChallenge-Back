<?php

namespace App\Core;


class Route
{
	private array $urls;
	
	public function add(string $url, string $controller, string $method, $args = []): void
	{
		$this->urls[$url] = [
			'controller' => $controller,
			'method' => $method,
			'args' => $args
		];
	}
	
	
	public function route($urlIn): void
	{
		$controller = $method = $args = null;
		foreach ($this->urls as $url => $param) {
			if ($urlIn === $url) {
				$controller = $param['controller'];
				$method = $param['method'];
				$args = $param['args'];
				break;
			}
		}
		$controller = new $controller();
		call_user_func_array([$controller, $method], $args);
	}
	
}