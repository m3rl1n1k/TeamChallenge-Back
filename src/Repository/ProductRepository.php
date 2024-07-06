<?php

namespace App\Repository;

use Core\DB\Model\AbstractModel;
use Core\Exceptions\DuplicateRecordsException;
use Exception;

class ProductRepository extends AbstractModel
{
	public function __construct()
	{
		parent::__construct();
		$this->table = "product";
	}

	/**
	 * @throws Exception
	 */
	public function getAll(array $params = []): false|array|string
	{
		$page = $params['page'];
		$limit = $params['limit'];
		$begin = ($page * $limit) - $limit;
		$this->setLimit($limit);
		$this->setPage($begin);
		$this->setSort($params['sort']);
		$this->setFilter($params['filter']);
		return $this->getChunked();
	}


	/**
	 * @throws DuplicateRecordsException
	 * @throws Exception
	 */
	public function save(array $data): bool
	{
		if ($this->findBy(['article' => $data['article']])) {
			throw new DuplicateRecordsException("Can't duplicate article {$data['article']}");
		}
		return $this->insert($data);
	}
}