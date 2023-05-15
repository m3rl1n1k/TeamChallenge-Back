<?php

namespace Bisix21\src\Core;

use http\Encoding\Stream\Inflate;

class Converter
{
	public function __construct(
		protected Validator $validator
	)
	{
	}

	public function commandCall(): string
	{
		return $this->prepareCommand();
	}

	protected function prepareCommand(): string
	{
		global $argv;
		$arr = array_slice($argv, 1);
		$this->validator->validateCommand($arr[0] ?? "");
		return $arr[0]; //отримуємо команду
	}

	public function getArguments(): array
	{
		global $argv;
		return array_slice($argv, 2); // отримуємо аргументи (сайт або код)
	}

}