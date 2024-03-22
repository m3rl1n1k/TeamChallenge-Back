<?php

namespace App\Core;


use App\Interface\RouteInterface;
use JetBrains\PhpStorm\NoReturn;

class Route implements RouteInterface
{
	private array $urls;
	private ?array $data = [];
	
	public function __construct()
	{
	}
	
	protected function add(string $uri, string $controller, string $action, string $method, $args = []): void
	{
		
		$this->urls[$uri] = [
			'controller' => $controller,
			'action' => $action,
			'method' => $method,
			'args' => $args
		];
	}
	
	public function get($uri, $controller, $action, $args = []): Route
	{
		$this->add($uri, $controller, $action, "GET", $args);
		return $this;
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
			$id = $this->data[array_key_first($this->data)];
			$uri = str_replace('{id}', $id, $uri);
			if ($uriIn === $uri && strtoupper($methodIn) === $param['method']) {
				$controller = $param['controller'];
				$action = $param['action'];
				$args = [];
            foreach ($this->data as $key => $value) {
                if (strpos($uri, '{' . $key . '}') !== false) {
                    $args[] = $value;
                }
            }
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
	
	public function addArgs(string $key, mixed $getId): static
	{
		$this->data = [];
		$this->data[$key] = $getId;
		return $this;
	}
}