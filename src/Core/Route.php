<?php

namespace App\Core;


use JetBrains\PhpStorm\NoReturn;

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
		if ($controller) {
			if (!method_exists($controller, $method)) {
				$this->printError("Method %s() Not Found!", $method);
			}
			$controller = new $controller();
			call_user_func_array([$controller, $method], $args);
		} else {
			$this->printError("Page <b style='background: #eee'>%s</b> Not Found!", $urlIn);
		}
	}
	
	#[NoReturn] protected function printError($msg, $value): void
	{
		printf($msg, $value);
		exit();
	}
}