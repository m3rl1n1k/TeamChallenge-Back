<?php

namespace App\Core\Helper;

class Printer
{

	const ANSI_RESET = "\e[0m";
	const ANSI_RED = "\e[31m";
	const ANSI_GREEN = "\e[32m";
	const ANSI_YELLOW = "\e[33m";
	const ANSI_BLUE = "\e[34m";

	protected static string $symbol = "=";
	protected static int $length = 0;

	public function __construct($symbol, $length)
	{
		self::$symbol = $symbol;
		self::$length = $length;
	}

	public static function printString(string $string, $color = Printer::ANSI_RESET): void
	{
		echo($color . $string . Printer::ANSI_RESET . PHP_EOL);
	}

	public static function printStringWithDivider(string $string): void
	{
		self::divider();
		echo $string . "\n";
		self::divider();
		echo "\n";
	}

	protected static function divider(): void
	{
		for ($i = 0; $i < self::$length; $i++) {
			echo self::$symbol;
		}
		echo "\n";
	}

	public static function printArray(array $data, $key = true): void
	{
		if (!$key) {
			self::noKey($data);
			exit();
		}
		foreach ($data as $key => $value) {
			echo Printer::ANSI_GREEN . $key . " => " . Printer::ANSI_YELLOW . $value . "\n" . Printer::ANSI_RESET;
		}
		echo "\n";
	}

	protected static function noKey($data): void
	{
		foreach ($data as $value) {
			echo $value . "\n";
		}
	}

	public static function printArrayWithDivider(array $data, $key = true): void
	{
		if (!$key) {
			self::divider();
			self::noKey($data);
			self::divider();
			exit();
		}
		self::divider();
		foreach ($data as $key => $value) {
			echo $key . " => " . $value . "\n";
		}
		self::divider();
		echo "\n";
	}

	public static function nextLine(): void
	{
		echo "<br>";
	}
}