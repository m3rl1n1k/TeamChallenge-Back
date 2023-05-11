<?php

namespace Bisix21\src\ORM;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

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
		$this->createDefaultTable();
	}

	protected function createDefaultTable(): void
	{
		Manager::schema()->create('urls_shorts', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('code');
			$table->string('url');
			$table->timestamps();
		});
	}
}