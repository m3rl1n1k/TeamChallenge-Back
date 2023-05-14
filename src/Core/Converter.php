<?php

namespace Bisix21\src\Core;

class Converter
{
	public function commandCall(): string
	{
		return $this->prepareCommand()[0];
	}

	protected function prepareCommand(): array
	{
		global $argv;
		return array_slice($argv, 1);
	}

	public function getArguments(): array
	{
		return array_slice($this->prepareCommand(), 1);
	}

}