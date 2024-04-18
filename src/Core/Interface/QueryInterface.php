<?php

namespace App\Core\Interface;

interface QueryInterface
{
    public function getQuery(): string;

    public function get();

    public function all();

    public function select(string $table, array $fields): self;

    public function where(string $field, string $value, string $operator = '='): self;


    public function orderBy(string $field, string $sort): self;

    public function limit(?int $offset, int $start = 0);

}