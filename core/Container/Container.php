<?php

namespace Core\Container;

use DiggPHP\Psr11\ContainerException;
use DiggPHP\Psr11\NotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
	private static ?Container $instance = null;
	private array $dependencies;

	private function __construct($dependencies = [])
	{
		$this->dependencies = $dependencies;
	}

	public static function call(string $class)
	{
		return Container::getInstance()->get($class);
	}

	/**
	 * @throws NotFoundExceptionInterface
	 * @throws ReflectionException|ContainerException
	 */
	public function get($id)
	{
		if (isset($this->dependencies[$id])) {
			return $this->dependencies[$id]($this);
		}

		return $this->prepare($id) ??
			throw new NotFoundException("Class $id not found!");
	}

	/**
	 * @throws NotFoundExceptionInterface
	 * @throws ContainerException
	 * @throws ReflectionException
	 * @throws NotFoundException
	 */
	protected function prepare(string $class)
	{
		$classReflector = new ReflectionClass($class);

		if ($classReflector->isInterface()) {
			throw new NotFoundException("No implementation found for interface $class");
		}

		$constructReflector = $classReflector->getConstructor();
		if ($constructReflector === null) {
			return new $class;
		}

		$constructArguments = $constructReflector->getParameters();
		if (empty($constructArguments)) {
			return new $class;
		}

		$args = [];
		foreach ($constructArguments as $argument) {
			$argumentType = $argument->getType();
			if ($argumentType === null || $argumentType->isBuiltin()) {
				if ($argument->isDefaultValueAvailable()) {
					$args[] = $argument->getDefaultValue();
				} elseif ($argumentType->getName() === 'array') {
					$args[] = []; // Для типу 'array' повертаємо порожній масив за замовчуванням
				} else {
					throw new ContainerException("Cannot resolve built-in parameter {$argument->getName()}");
				}
			} else {
				$args[] = $this->get($argumentType->getName());
			}
		}

		return new $class(...$args);
	}

	public static function getInstance($dependencies = []): self
	{
		if (null === self::$instance) {
			self::$instance = new self($dependencies);
		}
		return self::$instance;
	}

	public function has($id): bool
	{
		return array_key_exists($id, $this->dependencies);
	}

	public function set($id, $concrete): void
	{
		$this->dependencies[$id] = $concrete;
	}
}
