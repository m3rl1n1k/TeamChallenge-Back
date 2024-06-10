<?php

namespace Core\Interface;

interface QueryInterface
{
	public function getQuery(): string;

	public function get();

	public function all();

	public function save();

	public function select(string $table, array $fields): self;

	public function insert(string $table, array $data): self;

	public function update(string $table, array $data): self;

	public function delete(string $table): self;

	public function where(string $field, string $value, string $operator = '='): self;


	public function orderBy(string $field, string $sort): self;

	public function limit(?int $offset, int $start = 0);

}