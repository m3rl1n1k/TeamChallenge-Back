<?php

namespace Bisix21\src\Core;

class Handler
{
	protected string $givenCommand;

	public function __construct(
		protected Converter $converter,
		protected Command   $command
	)
	{
	}

	public function handle(): void
	{
		$this->givenCommand = $this->converter->commandCall();
		$this->command->run($this->givenCommand);
	}
}