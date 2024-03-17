<?php

namespace App\Core;

class Handler
{
	public function __construct(
		protected Request $request,
		protected Route   $route
	)
	{
	}
	
	public function handle(): void
	{
		Container::getInstance(Route::class);
	}
}