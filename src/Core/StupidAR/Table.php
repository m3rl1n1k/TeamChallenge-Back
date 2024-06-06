<?php

namespace App\Core\StupidAR;

use App\Core\Container\Container;

class Table
{
	protected string $table;
	protected array $fields;

	public function run(): void
	{
		/** @var RunSQLScript $script */
		$script = Container::call(RunSQLScript::class);
		$script->runSQL($this);
	}


}