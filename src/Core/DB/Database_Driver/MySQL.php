<?php

namespace App\Core\DB\Database_Driver;

use App\Core\Interface\ConnectionToDBInterface;
use Override;
use PDO;

class MySQL implements ConnectionToDBInterface
{

	#[Override] public static function connect(): ?PDO
	{
		return PDO_DB::getInstance();
	}

}