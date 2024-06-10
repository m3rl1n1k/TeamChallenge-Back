<?php

namespace App\Repository;

use Core\DB\Model\AbstractModel;
use Core\DB\QueryBuilder\QueryBuilder;
use Core\Exceptions\DuplicateRecordsException;
use Exception;

class User extends AbstractModel
{
	public function __construct(protected QueryBuilder $qb)
	{
		$this->table = 'user';
	}

	/**
	 * @throws Exception
	 */
	public function getUser(string $email)
	{
		$user = $this->findBy(['email' => $email]);
		unset($user['password']);
		return $user;
	}

	public function newUser(array $userData): bool
	{
		if ($this->findBy(['email' => $userData['email']])) {
			throw new DuplicateRecordsException("This email is taken!");
		}
		$userData['role'] = json_encode(['USER_ROLE']);
		return $this->insert($userData);
	}
}