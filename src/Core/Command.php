<?php

namespace Bisix21\src\Core;

use Bisix21\src\Classes\Divider;
use Bisix21\src\Core\DI\Container;

class Command
{
	public function __construct(
		protected array $allCommands,
	)
	{
	}

	public function run($givenCommand): void
	{
		foreach ($this->allCommands as $key => $command) {
			if ($givenCommand === $key) {
				Container::getInstance()->get($command)->runAction();
			}
		}
	}
}