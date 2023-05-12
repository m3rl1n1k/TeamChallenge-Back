<?php

namespace Bisix21\src\Commands;

use Bisix21\src\Interface\CommandInterface;

abstract class Command implements CommandInterface
{
	protected function getArgument()
	{
		return $this->arguments->getArguments()[0];
	}

	protected function getAllUrls(): ?array
	{
		return $this->record->read();
	}

}