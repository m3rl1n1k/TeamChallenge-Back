<?php

namespace Bisix21\src\Commands;

abstract class Command
{
	protected function getArgument()
	{
		return $this->arguments->getArguments()[0];
	}

	protected function getAllUrls():array
	{
		return $this->record->read();
	}

}