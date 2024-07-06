<?php

namespace App\Service;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Exception;
use LogicException;

class OrderService
{
	public function __construct(
		protected OrderRepository   $order,
		protected ProductRepository $product,
		protected UserRepository    $user)
	{
	}

	/**
	 * @throws Exception
	 */
	public function createOrder(array $orderData): void
	{
		// create order_item record for each product with (order_id, quantity, price,  etc.)
		// check payment data

		// prepare order data
		$orderData['user'] = $this->user->getUserId($orderData['recipient']['email']);
		$orderData[] = $orderData['order'];
		$totalPrice = $orderData['total_price'];
		$products = $orderData['order_products'];
		//
		d($orderData);
		foreach ($products as $product) {
			$preparedProduct = $this->product->findBy(['article' => $product['article']]);
			// get all  data about product for prepare their before update
			$preparedProduct = array_merge($preparedProduct, [
				'order_quantity' => $product['quantity'],
				'order_size' => $product['size'],
				'total_price' => $totalPrice,
			]);
			// minus quantity in product
			$product = $this->updateProduct($preparedProduct);
			$this->product->update($product, $product['article']);
		}
		// create order in table with data (total_price, user_id, status, order_date)
		$this->order->insert($orderData);
	}

	private function updateProduct(array $product): array
	{
		//	-> set buy product size quantity to -1
		$size = $product['order_size'];

		if (!is_int($size)) {
			throw new LogicException("Product size not found");
		}
		$orderSizeQuantity = $product['order_quantity'];
		$productSizeQuantity = $product['size'];

		if ($product['quantity'] == 0) {
			throw new LogicException("Quantity not enough for this product, article: {$product['article']}");
		}
		if ($orderSizeQuantity > $productSizeQuantity[$size]) {
			throw new LogicException("Quantity not enough for product with article {$product['article']} for this size, available {$productSizeQuantity}");
		}

		$productSizeQuantity[$size] = $productSizeQuantity[$size] - $orderSizeQuantity;
		//	-> set quantity product to -1
		$product['quantity'] = $product['quantity'] - $orderSizeQuantity;
		unset(
			$product['order_size'],
			$product['order_quantity'],
			$product['total_price']
		);
		return $product;

	}
}