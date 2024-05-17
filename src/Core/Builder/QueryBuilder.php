<?php

namespace App\Core\Builder;

use App\Core\DB\MySQL;
use App\Core\Interface\QueryInterface;
use Exception;
use Override;
use PDO;
use PDOStatement;
use stdClass;

class QueryBuilder implements QueryInterface
{
    protected ?PDO $DB;

    public function __construct(protected MySQL $PDO)
    {
        $this->DB = $this->PDO::connect();
    }

    private stdClass $query;

    public function select(string $table, array $fields): QueryBuilder
    {
        $this->reset();
        $this->query->type = 'select';
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function where(string $field, string $value, string $operator = '='): QueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->where[] = "$field $operator '$value'";// price = '10'

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
        if ($offset > 10 || $offset === null) {
            $offset = 10;
        }
        if ($this->query->type != 'select') {
            throw new Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }

    protected function reset(): void
    {
        $this->query = new stdClass();
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
        $res = $this->queryToDB();
        return !empty($res) ? $res->fetchAll(PDO::FETCH_ASSOC) : "Not found any product!";
    }

    public function get()
    {
        $res = $this->queryToDB();
        return !empty($res) ? $res->fetch(PDO::FETCH_ASSOC) : "Not found any product!";
    }

    public function save(): bool
    {
        return $this->queryToDB(true);
    }

    public function makeQuery()
    {
        return $this->queryToDB();
    }

    protected function queryToDB(bool $prepare = false): bool|PDOStatement
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->order)) {
            $sql .= $query->order;
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        if ($prepare) {
            $sql = $this->DB->prepare($sql);
            foreach ($query->data as $key => $value) {
                if (is_array($value)) {
                    $value = json_encode($value);
                }
                $sql->bindValue(":$key", $value);
            }
            $result = $sql->execute();
        } else {
            $result = $this->DB->query($sql);
        }
        return $result;
    }

    #[Override] public function getQuery(): string
    {
        return $this->query->base . $this->query->where . $this->query->limit;
    }
}