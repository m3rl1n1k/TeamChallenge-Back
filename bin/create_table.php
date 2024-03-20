#!/usr/bin/env php
<?php
require_once '../vendor/autoload.php';

// Перевірка, чи передано назву таблиці через командний рядок
use App\Core\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

if (isset($argv[1])) {
	$tableName = $argv[1];
} else {
	echo "Помилка: Назва таблиці не передана через командний рядок.\n";
	exit;
}

// Формування назви класу з використанням переданої назви таблиці
$class = ucfirst($tableName) . 'Table';

$class = Container::getInstance()->get($class);
try {
	// Перевірка, чи існує клас з такою назвою
	if (!class_exists($class)) {
		throw new Exception("Клас '$class' не знайдено.");
	}
	
	// Створення екземпляру класу
	$table = new $class();
	
	// Виклик методу schemaUp()
	$table->shemaUp();
	
	echo "Таблиця '$tableName' створена успішно.\n";
} catch (Exception $e) {
	echo "Помилка: " . $e->getMessage() . "\n";
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
}
