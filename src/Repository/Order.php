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

	public function saveOrder($orderData)
	{
		$this->insert($orderData);
	}
}