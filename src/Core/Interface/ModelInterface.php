<?php

namespace App\Core\Interface;

interface ModelInterface
{
    public function findBy(array $criteria);

    public function findAll();

    public function update($data, $id);

    public function delete(int $id);

}