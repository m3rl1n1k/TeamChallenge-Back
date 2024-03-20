<?php

namespace App\Core;

use Exception;
use PDO;

class ConnectionDB
{
	
	private static $dbInstance = null;
	
	// Prevent from creating instance
	private function __construct()
	{
	
	}
	
	// Prevent cloning the object
	private function __clone()
	{
	
	}
	
	public static function getInstance(): ?PDO
	{
		
		// Check if database is null
		if (self::$dbInstance == null) {
			
			// Create a new PDO connection
			try {
				$port = Config::instance()->get('database.port');
				$host = Config::instance()->get('database.host');
				$db = Config::instance()->get('database.db_name');
				$user = Config::instance()->get('database.user');
				$password = Config::instance()->get('database.password');
				self::$dbInstance = new PDO("mysql:host=$host;dbname=$db;port=$port", $user, $password);
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
		return self::$dbInstance;
	}
	
}