<?php

namespace Bisix21\src\Entity\Repository;

use Bisix21\src\Entity\Short;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

/**
 * @method Short|null find($id, $lockMode = null, $lockVersion = null)
 * @method Short|null findOneBy(array $criteria, array $orderBy = null)
 * @method Short[] findAll()
 * @method Short[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortRepository extends EntityRepository implements ObjectRepository
{
	public function getUrlByCode(string $code): Short|null
	{
		return $this->findOneBy([
			"code" => $code
		]);
	}

	public function getClassName(): string
	{
		return Short::class;
	}
}