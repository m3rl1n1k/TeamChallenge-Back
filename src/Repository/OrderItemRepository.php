<?php

namespace App\Repository;

use App\Service\UserService;
use Core\DB\Model\AbstractModel;
use Exception;

class OrderItemRepository extends AbstractModel
{

	public function __construct(protected UserService $user)
	{
		parent::__construct();
		$this->table = 'order_items';
	}

	/**
	 * @throws Exception
	 */
	public function save($product): bool
	{
		return false;
	}
}