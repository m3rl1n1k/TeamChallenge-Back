<?php

namespace Core\DB\Database_Driver;

use Core\Config;
use PDO;

class PDO_DB
{

	private static ?PDO $dbInstance = null;

	// Prevent from creating instance
	private function __construct()
	{

	}

	// Prevent cloning the object

	public static function getInstance(): ?PDO
	{

		// Check if database is null
		if (self::$dbInstance === null) {
			// Create a new PDO connection
			$dsn = Config::getValue('database.dsn');
			$user = Config::getValue('database.user');
			$password = Config::getValue('database.password');
			self::$dbInstance = new PDO($dsn, $user, $password,);
		}
		return self::$dbInstance;
	}

	private function __clone()
	{

	}
}