<?php

namespace Core\StupidAR;

trait TableTrait
{
	public function getFields(): array
	{
		return $this->fields;
	}

	public function getTable(): string
	{
		return $this->table;
	}
}