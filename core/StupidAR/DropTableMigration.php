<?php

namespace Core\StupidAR;

use Core\DB\Database_Driver\MySQL;
use Core\Helper\Printer;
use Core\Interface\runSQLInterface;
use Override;

class DropTableMigration implements runSQLInterface
{

	#[Override] public function runSQL($model): void
	{
		$db = MySQL::connect();

		$table = $model->getTable();
		$fields = [];

		$sql = "DROP TABLE $table";
		// check if table is exist, if yes then message "Table already exist!"
		$res = $db->exec($sql);
		if ($res) {
			Printer::printString("Failed to drop table!", Printer::ANSI_BLUE);
		} else {
			Printer::printString("Table is dropped!", Printer::ANSI_RED);
		}
	}
}