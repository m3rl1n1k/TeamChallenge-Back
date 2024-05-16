<?php

namespace App\Core\Interface;

interface ModelInterface
{
    public function find(mixed $id);

    public function findBy(array $criteria);

    public function findAll();

    public function delete(int $id);

}