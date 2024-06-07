<?php

namespace App\Core\StupidAR;

use App\Core\Container\Container;

class Table
{
	protected string $table;
	protected array $fields;

	public function run(): void
	{
		/** @var RunTableMigration $script */
		$script = Container::call(RunTableMigration::class);
		$script->runSQL($this);
	}

	public function drop(): void
	{
		/** @var DropTableMigration $script */
		$script = Container::call(DropTableMigration::class);
		$script->runSQL($this);
	}


}