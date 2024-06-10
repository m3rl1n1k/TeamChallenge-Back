<?php

namespace App\API;

use Core\Http\Request;

class OrderController
{
	public function __construct(protected Request $request)
	{
	}

	public function createOrder($request)
	{

		dd($request);

	}
}