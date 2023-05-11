<?php

namespace  Bisix21\src\Interface;

interface ContainerInterface
{
	public function get(string $id): mixed;

	public function has(string $id): bool;
}