<?php

namespace Bisix21\src\Commands;

abstract class Command
{
	protected function getArgument($key)
	{
		return $this->arguments->getArguments()[$key];
	}
}