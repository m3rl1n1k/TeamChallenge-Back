<?php

namespace Bisix21\src\Commands;

use Bisix21\src\Classes\Divider;
use Bisix21\src\Core\Validator;
use Bisix21\src\Interface\CommandInterface;

class DefaultCommands implements CommandInterface
{
	public function __construct(
		protected Validator $validator
	)
	{
	}

	protected function printAllCommands()
	{
		Divider::printArray(array_keys($this->validator->allowedCommands()), false);
	}

	public function runAction(): void
	{
		$this->printAllCommands();
	}
}