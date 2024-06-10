<?php

namespace Core\Route;

use BadMethodCallException;
use Core\Config;
use Core\Container\Container;
use Core\Http\Request;
use Core\Security\Middleware;
use DiggPHP\Psr11\NotFoundException;

class RouteService
{
	protected mixed $replacementPartURI;
	protected bool $params;

	public function __construct(protected Request $request, protected Middleware $middleware)
	{
	}

	/**
	 * @param $routes
	 * @return void
	 * @throws NotFoundException
	 */
	public function build($routes): void
	{
		$controller = $action = $arguments = null;
		$inputUrl = $this->request->getUrl();
		$inputMETHOD = $this->request->getMethod();

		foreach ($routes as $routeUri => $route) {
			$uri = $this->matchUrls($this->prepareUri($routeUri), $inputUrl);
			$method = $this->matchMethods($inputMETHOD, $route);
			if ($uri && $method) {
				$this->middleware->middleware($route['middleware']);

				$this->params = $route['params'] ?? false;
				$arguments = $this->getArguments();

				$controller = $route['controller'];
				$action = $route['action'];
				break;
			}
		}
		if (is_null($controller)) {
			throw new NotFoundException("Controller $controller or route $inputUrl not found!");
		}
		//Перевірка наявності контролера
		// Викликаємо метод контролера з переданими аргументами
		$this->call($controller, $action, $arguments);
	}

	/**
	 * @param string $uri
	 * @param string $inputUrl
	 * @return bool
	 */
	protected function matchUrls(string $uri, string $inputUrl): bool
	{
		/* if in $uri replacement part in the curl brackets changed to last part of input
		 * url $inputUrl, and they match return true, otherwise false
		 */
		$this->replacementPartURI = str_replace(['/', '{', '}'], null, $this->request->patternUrl($uri))[0];
		$value = $this->getReplacementID($inputUrl);
		if ($this->replacementPartURI) {
			$toPrepare = str_replace($this->replacementPartURI, $value, $uri);
			$uri = str_replace(['{', '}'], null, $toPrepare);
		}
		if ($uri === $inputUrl) {
			return true;
		}
		return false;
	}

	/**
	 * @param $url
	 * @return int|string
	 */
	protected function getReplacementID($url): int|string
	{
		return (int)$this->request->patternUrl($url, '/\d+$/')[0];//return array
	}

	/**
	 * @param int|string $uri
	 * @return string
	 */
	protected function prepareUri(int|string $uri): string
	{
		return explode('.', $uri)[1];
	}

	/**
	 * @param string $inputMETHOD
	 * @param mixed $route
	 * @return bool
	 */
	protected function matchMethods(string $inputMETHOD, mixed $route): bool
	{
		return strtoupper($inputMETHOD) === $route['method'];
	}

	/**
	 * @return array
	 */
	protected function getArguments(): array
	{
		return array_merge(
			$this->request->getBody(),
			$this->getParams(),
			$this->getArgumentsUrl()
		);
	}

	/**
	 * @return array
	 */
	protected function getParams(): array
	{
		if (!$this->params) {
			return [];
		}
		$params = $this->request->getParams();
		$param['params'] = empty($params) ? Config::getValue('config.default_request_data') : $params;
		return $param;
	}

	/**
	 * @return array|int[]|string[]|null
	 */
	protected function getArgumentsUrl(): ?array
	{
		if (empty($this->replacementPartURI)) {
			return [];
		}
		$inputUrl = $this->request->getUri();
		return [$this->replacementPartURI => $this->getReplacementID($inputUrl)];
	}

	/**
	 * @throws NotFoundException
	 */
	private function call(string $controller, string $action, array $args): void
	{

		if (!class_exists($controller)) {
			throw new NotFoundException("Controller $controller not found!");
		}
		if (!method_exists($controller, $action)) {
			throw new BadMethodCallException("Method $action() not found in class $controller!");
		}
		$controller = Container::call($controller);
		call_user_func_array([$controller, $action], $args);

	}
}