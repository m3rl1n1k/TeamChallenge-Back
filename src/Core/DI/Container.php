<?php

namespace DI;

use DiggPHP\Psr11\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{

	private static ?Container $instance = null;
	protected array $dependencies = [];

	private function __construct($dependencies = [])
	{
		$this->dependencies = $dependencies;
	}

	public static function instance($dependencies = []): Container
	{
		if (null === self::$instance) {
			self::$instance = new self($dependencies);
		}
		return self::$instance;
	}

	public function get(string $id): mixed
	{
		if ($this->has($id)) {
			return $this->resolve($id);
		} else {
			throw new NotFoundException("Dependency $id not found ");
		}
	}

	public function has(string $id): bool
	{
		return isset($this->dependencies[$id]);
	}

	private function resolve(string $id)
	{
		return call_user_func($this->dependencies[$id], $this);
	}
}