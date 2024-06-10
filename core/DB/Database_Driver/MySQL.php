<?php

namespace Core\DB\Database_Driver;

use Core\Interface\ConnectionToDBInterface;
use Override;
use PDO;

class MySQL implements ConnectionToDBInterface
{

	#[Override] public static function connect(): ?PDO
	{
		return PDO_DB::getInstance();
	}

}