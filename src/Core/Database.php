<?php

namespace App\Core;

use Illuminate\Database\Capsule\Manager;

class Database
{
	public function __construct(
		public array $configDbConnection,
	)
	{
		$this->connectToDB();
	}
	
	public function connectToDB(): void
	{
		$manager = new Manager();
		$manager->addConnection(Config::instance()->get('database'));
		$manager->setAsGlobal();
		$manager->bootEloquent();
	}
}