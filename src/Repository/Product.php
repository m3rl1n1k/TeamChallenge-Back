<?php

namespace App\Repository;

use Core\DB\Model\AbstractModel;
use Core\DB\QueryBuilder\QueryBuilder;
use Core\Exceptions\DuplicateRecordsException;
use Exception;
use LogicException;

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
		$this->setFilter($params['filter']);
		return $this->getChunked();
	}

	/**
	 * @throws Exception
	 */
	public function updateProduct($key, array $order, $product): void
	{
		//	-> set buy product size quantity to -1
		$size = $order[$key]['size'];
		if (!is_int($size)) {
			throw new LogicException("Product size not found");
		}
		$orderSizeQuantity = $order[$key]['quantity'];
		$productSizeQuantity = $product['size'][$size];
		if ($orderSizeQuantity > $productSizeQuantity) {
			throw new LogicException("Quantity not enough for product with article {$product['article']} for this size, available {$productSizeQuantity}");
		}
		$product['size'][$size] = $productSizeQuantity - $orderSizeQuantity;
		//	-> set quantity product to -1
		$product['quantity'] = $product['quantity'] - $orderSizeQuantity;


		$this->update($product, $product['article']);
	}

	public function update($data, $article): bool
	{
		$record = $this->findBy(['article' => $article]);
		$this->recordNotFound($record);
		return $this->qb->update($this->table, $data)->where('article', $article)->save();
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