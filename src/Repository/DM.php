<?php

namespace Bisix21\src\Repository;

use Bisix21\src\Entity\Repository\ShortRepository;
use Bisix21\src\Entity\Short;
use Bisix21\src\Interface\DBInterface;
use Bisix21\src\UrlShort\Decode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\ORMException;
use InvalidArgumentException;

class DM implements DBInterface
{
	public function __construct(
		protected Decode        $decode,
		protected Short         $short,
		protected EntityManager $entityManager,
	)
	{
	}

	/**
	 * @throws ORMException
	 */
	public function saveToDb($data): void
	{
		$shortRep = $this->entityManager->getRepository(Short::class);
		if (!$shortRep->issetCode($data['code'])) {
			throw new InvalidArgumentException("You have same record: {$data['code']} => {$data['url']}");
		}
//		dd($shortRep->issetCode($data['code']));
		$this->short->setCode($data['code']);
		$this->short->setUrl($data['url']);
		$this->entityManager->persist($this->short);
		$this->entityManager->flush();
	}

	/**
	 * @throws NotSupported
	 */
	public function read(string $code): string
	{
		/** @var ShortRepository $shortRep */
		$shortRep = $this->entityManager->getRepository(Short::class);
		$short = $shortRep->getUrlByCode($code);
		if (is_null($short)) {
			throw new InvalidArgumentException(" Undefined code $code");
		}
		return $this->decode->decode($short->getCode());
	}
}