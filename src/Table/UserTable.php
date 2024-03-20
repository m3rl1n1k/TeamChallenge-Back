<?php

namespace App\Table;

use Illuminate\Database\Capsule\Manager;

class UserTable
{
	public function shemaUp()
	{
		Manager::schema()->create('users', function ($table) {
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('name');
			$table->timestamps();
		});
	}
}