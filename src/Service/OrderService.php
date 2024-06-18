<?php

namespace App\Service;

use App\Repository\Order;
use App\Repository\Product;
use Core\Exceptions\NotSendHeaders;
use Core\Http\Response;
use Exception;

class OrderService
{
	public function __construct(protected Product $product, protected Order $order)
	{
	}

	/**
	 * @throws NotSendHeaders
	 */
	public function createOrder($request): bool
	{
		try {
			// prepare order data
			$order = $request['order'];
			$products = $this->prepare($order);
			//	make changes in db
			foreach ($products as $productName => $product) {
				// call transaction
				$this->order->query()->beginTransaction();
				$this->product->updateProduct($productName, $order, $product);
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
		return $status ?? false;
	}

	/**
	 * @throws Exception
	 */
	protected function prepare(array $products): array
	{
		foreach ($products['order_products'] as $key => $product) {
			$products['products'][$key] = $this->getProduct($product['article']);
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
