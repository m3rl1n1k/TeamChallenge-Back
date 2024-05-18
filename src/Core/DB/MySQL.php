<?php

namespace App\Core\DB;

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