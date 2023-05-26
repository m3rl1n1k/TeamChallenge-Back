<?php

namespace Bisix21\src\Core;

use Bisix21\src\Classes\GetRequest;

class Converter
{
	public function __construct(
		protected Validator  $validator,
	)
	{
	}

	public function commandCall(): string
	{
		return $this->prepareCommand();
	}
	public function getArguments(): array
	{
		global $argv;
		return array_slice($argv, 2); // отримуємо аргументи (сайт або код)
	}

	protected function prepareCommand(): string
	{
		global $argv;
		$res = "";
		if (!empty($argv)) {
			$arr = array_slice($argv, 1);
			$this->validator->validateCommand($arr[0] ?? "");
			$res = $arr[0];
		}
		return $res; //отримуємо команду}
	}

}