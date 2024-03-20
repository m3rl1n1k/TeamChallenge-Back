<?php

namespace App\Core;


use JetBrains\PhpStorm\NoReturn;

class Route
{
	private array $urls;
	
	protected function add(string $uri, string $controller, string $action, string $method, $args = []): void
	{
		
		$this->urls[$uri] = [
			'controller' => $controller,
			'action' => $action,
			'method' => $method,
			'args' => $args
		];
	}
	
	public function get($uri, $controller, $action, $args = []): void
	{
		$this->add($uri, $controller, $action, "GET", $args);
	}
	
	public function post($uri, $controller, $action, $args = []): void
	{
		$this->add($uri, $controller, $action, "POST", $args);
	}
	
	public function put($uri, $controller, $action, $args = []): void
	{
		$this->add($uri, $controller, $action, "PUT", $args);
	}
	
	public function patch($uri, $controller, $action, $args = []): void
	{
		$this->add($uri, $controller, $action, "PATCH", $args);
	}
	
	public function delete($uri, $controller, $action, $args = []): void
	{
		$this->add($uri, $controller, $action, "DELETE", $args);
	}
	
	
	public function route($uriIn, $methodIn): void
	{
		$controller = $action = $args = null;
		foreach ($this->urls as $uri => $param) {
			 $uri = str_replace('{id}', $param['args']['id'], $uri);
			if ($uriIn === $uri && strtoupper($methodIn) === $param['method']) {
				$controller = $param['controller'];
				$action = $param['action'];
				$args = $param['args'];
				break;
			}
		}
		if ($controller) {
			if (!method_exists($controller, $action)) {
				$this->printError("Method %s() Not Found!", $action);
			}
			$controller = new $controller();
			call_user_func_array([$controller, $action], $args);
		} else {
			$this->printError("Page <b style='background: #eee'>%s</b> Not Found!", $uriIn);
		}
	}
	
	#[NoReturn] protected function printError($msg, $value): void
	{
		printf($msg, $value);
		exit();
	}
}