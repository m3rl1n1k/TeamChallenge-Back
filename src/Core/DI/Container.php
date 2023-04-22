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

	public function get($id)
	{
		if (!$this->has($id)) {
			throw new NotFoundException("Dependency {$id} not found");
		}

		$dependency = $this->dependencies[$id];

		if (is_callable($dependency)) {
			$dependency = $dependency($this);
		}

		return $dependency;
	}

	public function has($id): bool
	{
		return array_key_exists($id, $this->dependencies);
	}


	/**
	 * @throws NotFoundException
	 */
	private function resolve(string $id)
	{
		if (!isset($this->dependencies[$id])) {
			throw new NotFoundException("Dependency $id not found ");
		}

		$dependency = $this->dependencies[$id];

		if (is_callable($dependency)) {
			$resolvedDependency = $dependency($this);
			$this->dependencies[$id] = $resolvedDependency;
			return $resolvedDependency;
		}

		return $dependency;
	}
}