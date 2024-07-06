<?php

namespace Core\StupidAR;

trait TableTrait
{
	protected function save($data): void
	{
		$this->getEntityManager()->persist($data);
		$this->getEntityManager()->flush();
	}
}