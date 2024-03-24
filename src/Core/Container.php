<?php

namespace App\Core;

use DiggPHP\Psr11\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
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
	
	public static function getInstance($dependencies = []): self
	{
		if (null === self::$instance) {
			self::$instance = new self($dependencies);
		}
		return self::$instance;
	}
	
	/**
	 * @throws NotFoundExceptionInterface
	 * @throws NotFoundException
	 * @throws ReflectionException
	 * @throws ContainerExceptionInterface
	 */
	public function get($id)
	{
		return  $this->prepare($id) ??
			throw new NotFoundException("Class $id not found!");
	}
	
	public function has($id): bool
	{
		return array_key_exists($id, $this->dependencies);
	}
	
	/**
	 * @throws ReflectionException
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	protected function prepare(string $class)
	{
		$classReflector = new \ReflectionClass($class);
		
		// Получаем рефлектор конструктора класса, проверяем - есть ли конструктор
		// Если конструктора нет - сразу возвращаем экземпляр класса
		$constructReflector = $classReflector->getConstructor();
		if ($constructReflector === null) {
			return new $class;
		}
		
		// Получаем рефлекторы аргументов конструктора
		// Если аргументов нет - сразу возвращаем экземпляр класса
		$constructArguments = $constructReflector->getParameters();
		if (empty($constructArguments)) {
			return new $class;
		}
		
		// Перебираем все аргументы конструктора, собираем их значения
		$args = [];
		foreach ($constructArguments as $argument) {
			// Получаем тип аргумента
			$argumentType = $argument->getType()->getName();
			// Получаем сам аргумент по его типу из контейнера
			$args[$argument->getName()] = $this->get($argumentType);
		}
		
		// И возвращаем экземпляр класса со всеми зависимостями
		return new $class(...$args);
	}
	
	protected function isEmptyArgOrParam($condition, $callback)
	{
		$res = null;
		if (empty($condition)) {
			$res = $callback();
		}
		return $res;
	}
}