<?php

namespace App\API;

use App\Model\User;
use Illuminate\Database\RecordsNotFoundException;

class UserController
{
	public function __construct(protected User $user)
	{
	}
	
	public function index($id)
	{
		$users = User::query()->select()->where(['id' => $id]);
		if (!$users){
			throw new RecordsNotFoundException("User with $id, not founded!");
		}

	}
}