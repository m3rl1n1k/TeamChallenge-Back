<?php

namespace App\Core;


use App\Interface\RouteInterface;
use JetBrains\PhpStorm\NoReturn;

class Route implements RouteInterface
{
	private array $urls;
	private Request $request;
	
	public function __construct()
	{
		$this->request = new Request();
	}
	
	protected function add(string $uri, string $controller, string $action, string $method): void
	{
		
		$this->urls[$uri] = [
			'controller' => $controller,
			'action' => $action,
			'method' => $method,
		];
	}
	
	public function get($uri, $controller, $action): Route
	{
		$this->add($uri, $controller, $action, "GET");
		return $this;
	}
	
	public function post($uri, $controller, $action): void
	{
		$this->add($uri, $controller, $action, "POST");
	}
	
	public function put($uri, $controller, $action): void
	{
		$this->add($uri, $controller, $action, "PUT");
	}
	
	public function patch($uri, $controller, $action): void
	{
		$this->add($uri, $controller, $action, "PATCH");
	}
	
	public function delete($uri, $controller, $action): void
	{
		$this->add($uri, $controller, $action, "DELETE");
	}
	
	
	public function route($uriIn, $methodIn): void
	{
		$controller = $action = $arg = null;
		foreach ($this->urls as $uri => $param) {
			$arg = $this->request->getContent()?? $this->getArg($uri, $uriIn);
			$uri = preg_match('/{[A-Za-z]+}/', $uri) ? $this->getArg($uri, $uriIn, true) : $uri;
			// Перевіряємо, чи співпадає URI та метод
			if ($uriIn === $uri && strtoupper($methodIn) === $param['method']) {
				$controller = $param['controller'];
				$action = $param['action'];
				break;
			}
		}
		
		// Викликаємо метод контролера з переданими аргументами
		if ($controller) {
			if (!method_exists($controller, $action)) {
				$this->printError("Method %s() Not Found!", $action);
			}
			$controller = new $controller();
			if ($arg) {
				call_user_func_array([$controller, $action], $arg);
			} else {
				call_user_func_array([$controller, $action], []);
			}
			
		} else {
			$this->printError("Page <b style='background: #eee'>%s</b> Not Found!", $uriIn);
		}
	}
	
	
	#[NoReturn] protected function printError($msg, $value): void
	{
		printf($msg, $value);
		exit();
	}
	
	private function getArg(string $uri, string $uriIn, bool $replace = false): array|string
	{
		$key = $id = null;
		if (preg_match('/\/(\d+)$/', $uriIn, $matches)) {
			$id = $matches[1];
			//'/{[A-Za-z]+}/'
			if (preg_match('/{[A-Za-z]+}/', $uri, $matches)) {
				$key = trim($matches[0], '{}');
			}
		}
		if ($replace) {
			return str_replace($matches[0], $id, $uri);
//			return  $uri;
		}
		return $id ? [$key => $id] : [];
	}
}