<?php

namespace App\Core\Route;

use App\Core\Config;
use App\Core\Container\Container;
use App\Core\Http\Request;
use App\Core\Security\Middleware;
use BadMethodCallException;
use DiggPHP\Psr11\NotFoundException;

class RouteService
{
	protected mixed $replacementPartURI;

	public function __construct(protected Request $request, protected Middleware $middleware)
	{
	}

	/**
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
				$arguments = $this->getArguments();

				$controller = $route['controller'];
				$action = $route['action'];
				$this->middleware->middleware($route['middleware']);
				break;
			}
		}
		if (is_null($controller)) {
			throw new NotFoundException("Controller $controller or route $inputUrl not found!");
		}
		//Перевірка наявності контролера
		// Викликаємо метод контролера з переданими аргументами
		$this->callController($controller, $action, $arguments);
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
		$this->replacementPartURI = str_replace(['/', '{', '}'], null, $this->request->isPatternUri($uri))[0];
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
		return (int)$this->request->isPatternUri($url, '/\d+$/')[0];//return array
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
	 * @return false|array|string
	 */
	protected function getArguments(): false|array|string
	{
		return array_merge(
			$this->request->getRequestBody(),
			$this->getParams(),
			$this->getArgumentsUrl()
		);
	}

	/**
	 * @return array
	 */
	protected function getParams(): array
	{
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
		$inputUrl = $this->request->getRequestUri();
		return [$this->replacementPartURI => $this->getReplacementID($inputUrl)];
	}

	/**
	 * @throws NotFoundException
	 */
	private function callController(string $controller, string $action, array|string $args): void
	{

		if (!class_exists($controller)) {
			throw new NotFoundException("Controller $controller not found!");
		}
		if (!method_exists($controller, $action)) {
			throw new BadMethodCallException("Method $action() not found!");
		}
		$controller = Container::call($controller);
		if (is_string($args)) {
			call_user_func_array([$controller, $action], []);
		} else {
			call_user_func_array([$controller, $action], $args);
		}
	}
}