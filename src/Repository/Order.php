<?php

namespace App\Repository;

use Core\DB\Model\AbstractModel;
use Core\DB\QueryBuilder\QueryBuilder;

class Order extends AbstractModel
{
	public function __construct(protected QueryBuilder $qb)
	{
		$this->table = "order";
	}

	public function save($orderData): void
	{
		d($orderData);
		$preparedData = [
			'user_id' => $orderData['user_id'],
			'product_article' => $orderData['article'],
			'quantity' => $orderData['quantity'],
			'total_price' => $orderData['total_price'],
			'status' => $orderData['status'],
		];
		$this->insert($preparedData);
	}
}