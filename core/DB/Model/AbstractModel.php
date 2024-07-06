<?php

namespace Core\DB\Model;

use Core\DB\QueryBuilder\QueryBuilder;
use Core\Interface\ModelInterface;
use DiggPHP\Psr11\NotFoundException;
use Exception;

abstract class AbstractModel implements ModelInterface
{
	protected string $table;
	protected ?array $orderBy;
	protected ?int $limit;
	protected QueryBuilder $qb;
	protected ?int $page;

	public function findAll(): false|array|string
	{
		$records = $this->qb->select($this->table)->all();
		foreach ($records as $key => $record) {
			$records[$key]['size'] = json_decode($record['size']);
		}
		return $records;

	}

	/**
	 * @throws Exception
	 */
	public function update($data, $id): bool
	{
		return $this->qb->update($this->table, $data)->where('article', $id)->save();
	}

	/**
	 * @throws Exception
	 */
	public function findBy(array $criteria)
	{
		return $this->qb->select($this->table)->where(array_key_first($criteria), array_values($criteria)[0])->get();
	}

	/**
	 * @throws Exception
	 */
	public function delete($id)
	{
		return $this->qb->delete($this->table)->where('article', $id)->get();
	}

	/**
	 * @throws Exception
	 */
	public function getChunked(): false|array|string
	{
		$records = $this->qb->select($this->table)->limit($this->limit, $this->page)->orderBy($this->orderBy[0], $this->orderBy[1])->all();
		foreach ($records as $key => $record) {
			$records[$key]['size'] = json_decode($record['size']);
		}
		return $records;

	}

	public function insert(array $data): bool
	{
		return $this->qb->insert($this->table, $data)->save();
	}

	public function recordNotFound($record): void
	{
		if (!$record) {
			throw new NotFoundException('Record not found!');
		}
	}

	public function setLimit(?int $limit): static
	{
		if ($limit === null) {
			$limit = 10;
		}
		$this->limit = $limit;
		return $this;
	}

	public function setSort(?string $orderBy): static
	{
		$this->orderBy = $this->orderPrepare($orderBy ?? "price.up");
		return $this;
	}

	private function orderPrepare(string $sort): array
	{
		$field = explode('.', $sort);
		if ($field[0] === "up") {
			$field[1] = "DESC";
		} else {
			$field[1] = "ASC";
		}
		return $field;
	}

	public function setPage(?int $page): static
	{
		if ($page === null) {
			$page = 1;
		}
		$this->page = $page;
		return $this;
	}

	protected function setFilter()
	{

	}
}