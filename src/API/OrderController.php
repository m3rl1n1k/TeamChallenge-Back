<?php

namespace App\API;

use App\Repository\Order;
use App\Repository\Product;
use Core\Http\HttpStatusCode;
use Core\Http\Request;
use Core\Http\Response;
use Exception;

class OrderController
{
	public function __construct(
		protected Request $request,
		protected Product $product,
		protected Order   $order)
	{
	}

	/**
	 * @throws Exception
	 */
	public function createOrder($request)
	{
		try {
			// prepare order data
			$orderProduct = $request['products'];

			$products = $this->prepare($orderProduct);
			//	make changes in db
			foreach ($products as $key => $product) {
				// call transaction
				$this->order->query()->beginTransaction();
				$this->product->updateProduct();

				$this->order->save($product);
				$this->order->query()->commit();
				$status = true;
			}
			// call payment
		} catch (Exception $exception) {
			new Response($exception->getMessage());
			$this->order->query()->rollBack();
			$status = false;
		}
		return $status ? new Response("Order created", HttpStatusCode::CREATED) : new Response("Failed to create order", HttpStatusCode::BAD_REQUEST);

		// save order to db

	}

	protected function prepare(array $products): array
	{
		foreach ($products as $key => $product) {
			$products[$key] = $this->getProduct($product['article']);
		}
		return $products;
	}

	/**
	 * @throws Exception
	 */
	private function getProduct(int $article)
	{
		$product = $this->product->findBy(['article' => $article]);
		$product['size'] = json_decode($product['size'], true);
		return $product;
	}
}