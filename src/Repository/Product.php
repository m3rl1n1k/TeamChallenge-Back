<?php

namespace App\Repository;

use Core\DB\Model\AbstractModel;
use Core\DB\QueryBuilder\QueryBuilder;
use Core\Exceptions\DuplicateRecordsException;
use Exception;

class Product extends AbstractModel
{
	public function __construct(protected QueryBuilder $qb)
	{
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
//		$this->setFilter($params['filter']);
		return $this->getChunked();
	}

	public function update($data, $id): bool
	{
		$record = $this->findBy(['article' => $id]);
		$this->recordNotFound($record);
		return $this->qb->update($this->table, $data)->where('article', $id)->save();
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

	public function delete($id)
	{
		$record = $this->findBy(['article' => $id]);
		$this->recordNotFound($record);
		return $this->qb->delete($this->table)->where('article', $id)->get();
	}
}