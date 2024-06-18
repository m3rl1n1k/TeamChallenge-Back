<?php

namespace App\Repository;

use App\Enum\OrderStatusEnum;
use App\Service\UserService;
use Core\DB\Model\AbstractModel;
use Core\DB\QueryBuilder\QueryBuilder;
use Exception;
use LogicException;

class Order extends AbstractModel
{
	public function __construct(protected QueryBuilder $qb, protected UserService $userService)
	{
		$this->table = "order";
	}

	/**
	 * @throws Exception
	 */
	public function save(array $orderData): void
	{
		$this->validate($orderData);
		$recipient = $this->userService->getUser();
		$preparedData = [
			'user_id' => $recipient['id'],
			'product_article' => $orderData['article'],
			'quantity' => $orderData['quantity'],
			'status' => $orderData['status'] ?? OrderStatusEnum::prepare,
		];
		$this->insert($preparedData);
	}

	private function validate(array $orderData)
	{
		if ($orderData['total_price'] === null) {
			throw new LogicException("Not set total price!");
		}

	}
}