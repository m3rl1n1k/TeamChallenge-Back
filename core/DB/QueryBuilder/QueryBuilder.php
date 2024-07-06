<?php

namespace Core\DB\QueryBuilder;

use Core\DB\Database_Driver\MySQL;
use Core\Interface\QueryInterface;
use Exception;
use LogicException;
use PDO;
use PDOStatement;
use stdClass;

class QueryBuilder implements QueryInterface
{
	protected ?PDO $DB_PDO;
	private stdClass $query;

	public function __construct(protected MySQL $PDO)
	{
		$this->DB_PDO = $this->PDO::connect();
	}

	public function select(string $table, array $fields = ['*']): QueryBuilder
	{
		$this->reset();
		$this->query->type = 'select';
		$this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
		return $this;
	}

	protected function reset(): void
	{
		$this->query = new stdClass();
	}

	public function filter(array $filters): static
	{
		foreach ($filters as $field => $value) {
			if (is_array($value)) {
				$this->where($field, $value);
			} else {
				$this->where($field, $value);
			}
		}
		return $this;
	}

	public function where(string $field, string|int|array $value, string $operator = '='): QueryBuilder
	{
		if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
			throw new LogicException("WHERE can only be added to SELECT, UPDATE OR DELETE");
		}

		if (is_array($value)) {
			if ($operator != '=') {
				throw new LogicException("Operator must be '=' when value is an array");
			}
			$value = "'" . implode("', '", $value) . "'";
			$this->query->where[] = "$field IN ($value)"; // field IN ('val1', 'val2')
		} else {
			$value = is_string($value) ? "'$value'" : "$value";
			$this->query->where[] = "$field $operator $value"; // field = 'value'
		}

		return $this;
	}

	public function insert(string $table, array $data): QueryBuilder
	{
		$this->reset();
		$query = $this->query;
		$query->type = 'insert';
		$columns = implode(', ', array_keys($data));
		$placeholders = ':' . implode(', :', array_keys($data));
		$query->data = $data;
		$query->base = "INSERT INTO $table ($columns) VALUES ($placeholders)";
		return $this;
	}

	public function update(string $table, array $data): static
	{
		$this->reset();
		$this->query->type = 'update';
		$set = [];
		foreach ($data as $key => $value) {
			$set[] = "$key = :$key";
		}
		$setClause = implode(', ', $set);
		$this->query->base = "UPDATE $table SET $setClause ";
		$this->query->data = $data;
		return $this;
	}

	public function delete(string $table): static
	{
		$this->reset();
		$query = $this->query;
		$query->type = "delete";
		$query->base = "DELETE FROM $table ";
		return $this;
	}

	public function limit(?int $offset, int $start = 0): QueryBuilder
	{
		if ($offset > 100 || $offset === null) {
			$offset = 100;
		}
		if ($this->query->type !== 'select') {
			throw new Exception("LIMIT can only be added to SELECT");
		}
		$this->query->limit = " LIMIT " . $start . ", " . $offset;
		return $this;
	}

	public function orderBy(string $field, string $sort): static
	{
		if ($this->query->type != 'select') {
			throw new Exception("ORDER can only be added to SELECT");
		}
		$this->query->order = " ORDER BY " . $field . " " . $sort;
		return $this;
	}

	public function all(): false|array|string
	{
		$res = $this->queryToDB()->fetchAll(PDO::FETCH_OBJ);
//		d($res);
		foreach ($res as $record) {
			$record->size = json_decode($record->size, true);
		}
		return $res;
	}

	protected function queryToDB(bool $prepare = false): PDOStatement
	{
		$query = $this->query;
		$sql = $query->base;

		// Додавання умов WHERE
		if (!empty($query->where)) {
			$sql .= " WHERE " . implode(' AND ', $query->where);
		}

		// Додавання ORDER BY
		if (isset($query->order)) {
			$sql .= $query->order;
		}

		// Додавання LIMIT
		if (isset($query->limit)) {
			$sql .= $query->limit;
		}

		if ($prepare) {
			$sql = $this->DB_PDO->prepare($sql);
			foreach ($query->data as $key => $value) {
				if (is_array($value)) {
					$value = json_encode($value);
				}
				$sql->bindValue(":$key", $value);
			}
			$result = $sql->execute();
		} else {
			$result = $this->DB_PDO->query($sql);
		}
		return $result;
	}


	public function get()
	{
		$result = $this->queryToDB()->fetch(PDO::FETCH_OBJ);
		// todo make validation and decode from json
//		if (in_array('size', array_keys($result))) {
//			$result->size = json_decode($result->size, true);
//		}
		return $result;
	}

	public function save()
	{
		return $this->queryToDB(true);
	}

	public function getQuery(): stdClass
	{
		return $this->query;
	}
}
