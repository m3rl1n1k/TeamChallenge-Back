<?php

namespace App\Core\Builder;

use App\Core\Database;
use App\Core\Interface\QueryInterface;
use Exception;
use PDO;
use stdClass;

class QueryBuilder implements QueryInterface
{
    public function __construct(protected Database $DB)
    {
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

    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->DB->prepare($sql);

        if ($data['size']) {
            $data['size'] = json_encode($data['size']);
        }
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
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
        $sql = "UPDATE $table SET $setClause WHERE ";
        $this->query->base = $sql;
        $this->query->data = $data;
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

    public function getQuery(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";
        return $sql;
    }

    public function all(): false|array|string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";
        $res = $this->DB->query($sql);
        return !empty($res) ? $res->fetchAll(PDO::FETCH_ASSOC) : "Not found any product!";
    }

    public function orderBy(string $field, string $sort): static
    {
        if ($this->query->type != 'select') {
            throw new Exception("ORDER can only be added to SELECT");
        }
        $this->query->order = " ORDER BY " . $field . " " . $sort;

        return $this;
    }

    public function get()
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        $sql .= ";";
        $res = $this->DB->query($sql);
        return !empty($res) ? $res->fetch(PDO::FETCH_ASSOC) : "Not found any product!";
    }

    public function save(): bool
    {
        $sql = $this->query->base;
        if (!empty($this->query->where)) {
            $sql .= implode(' AND ', $this->query->where);
        }
        $sql = $this->DB->prepare($sql);
        foreach ($this->query->data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $sql->bindValue(":$key", $value);
        }
        return $sql->execute();
    }
}