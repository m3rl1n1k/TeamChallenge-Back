<?php

namespace Core\Interface;

interface ModelInterface
{
	public function findBy(array $criteria);

	public function findAll();

	public function update($data, $article);

	public function delete(int $id);

}