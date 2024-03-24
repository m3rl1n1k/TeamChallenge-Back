<?php

namespace App\Core;

class Handler
{
	public function handle(): void
	{
		Container::getInstance(Route::class);
	}
}