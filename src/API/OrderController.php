<?php

namespace App\API;

use App\Service\OrderService;
use Exception;

class OrderController
{
	public function __construct(protected OrderService $orderService)
	{
	}

	/**
	 * @throws Exception
	 */
	public function createOrder($request)
	{
		$this->orderService->createOrder($request);// ? new Response("Order created", HttpStatusCode::CREATED) : new Response("Failed to create order", HttpStatusCode::BAD_REQUEST);

		// save order to db

	}
}