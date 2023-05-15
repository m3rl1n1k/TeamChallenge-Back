<?php

namespace Bisix21\src\Core;

use InvalidArgumentException;

class Validator
{

	public function __construct(
		protected array $allCommands
	)
	{
	}

	public function link($link): bool|int
	{
		// прротокол + доменна назва . домен : порт(якщо існує)/ назва каталогу
		$pattern = '/^https?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})(:[0-9]{1,5})?(\/.*)?$/i';
		$this->isEmpty($link);
		$res = preg_match($pattern, $link);
		if (!$res) {
			throw new InvalidArgumentException('Invalid url');
		}
		return $res;
	}

	protected function isEmpty($value): void
	{
		if (empty($value)) {
			throw new InvalidArgumentException('Invalid argument');
		}
	}

	public function issetIn($value, $array): bool
	{
		$this->isEmpty($array);
		if (array_search($value, $array)) {
			return false;
		}
		return true;
	}

	public function validateCommand($command): void
	{
		if ($command == null) {
			$this->invalidArgument();
		}
		if (array_keys($this->allowedCommands(), $command)) {
			$this->invalidArgument();
		}
	}

	protected function invalidArgument()
	{
		throw new InvalidArgumentException("Not found command. Print help to see all commands");
	}

	public function allowedCommands(): array
	{
		$allowed = [];
		foreach ($this->allCommands as $key => $command) {
			$key = explode(":", $key);
			if (strtolower($key[0]) == "allowed") {
				$allowed[$key[1]] = $command;
			}
		}
		return $allowed;
	}

}