<?php

namespace ORM;

use Illuminate\Database\Capsule\Manager;
class ActiveRecord
{
	public function __construct(
		public array $configDbConnection,
	)
	{
		$this->db();
	}

	public function db(): void
	{
		$manager = new Manager();
		$manager->addConnection($this->configDbConnection);
		$manager->setAsGlobal();
		$manager->bootEloquent();
}
}