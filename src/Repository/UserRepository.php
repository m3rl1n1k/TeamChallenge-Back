<?php

namespace App\Repository;

use App\Entity\User;
use Core\StupidAR\TableTrait;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Exception;

class UserRepository extends EntityRepository
{
	protected mixed $user;

	use TableTrait;

	public function __construct(protected EntityManager $em, ClassMetadata $class)
	{
		parent::__construct($em, $class);
	}

	/**
	 * @throws Exception
	 */
	public function getUser(string $email): array
	{
		return $this->findBy(['email' => $email]);
	}

	public function newUser(array $userData): void
	{
		$user = new User();
		$user->setEmail($userData['email'])
			->setPassword($userData['password'])
			->setRole($userData['role'])
			->setFirstName($userData['firstName'])
			->setLastName($userData['lastName'])
			->setCity($userData['city'])
			->setAddress($userData['street'])
			->setState($userData['state'])
			->setZipCode($userData['zipCode'])
			->setPhone($userData['phone']);
		$this->save($user);
	}

	/**
	 * @throws Exception
	 */
	public function getUserId(mixed $email): int
	{
		/** @var User $user */
		$user = $this->findBy(['email' => $email]);
		return $user->getId();
	}
}