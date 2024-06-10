<?php

namespace Core\StupidAR;

use Core\DB\Database_Driver\MySQL;
use Core\Helper\Printer;
use Core\Interface\runSQLInterface;
use Override;

class RunTableMigration implements runSQLInterface
{
	#[Override] public function runSQL($model): void
	{
		$db = MySQL::connect();

		$table = $model->getTable();
		$fields = [];

		foreach ($model->getFields() as $field => $type) {
			if (!is_int($field))
				$fields[] = str_replace(' ', '_', $field) . " $type";
			else
				$fields[] = $type;
		}

		$fields = implode(', ', $fields);
		$sql = "CREATE TABLE IF NOT EXISTS $table ($fields)";
		// check if table is exist, if yes then message "Table already exist!"
		$stmt = $db->query("SHOW TABLES LIKE '$table'");
		if ($stmt->rowCount() > 0) {
			// Table already exists
			Printer::printString("Table already exists!", Printer::ANSI_YELLOW);
		} else {
			// Table does not exist, create it
			$res = $db->exec($sql);
			if ($res) {
				Printer::printString("Failed to create table!", Printer::ANSI_RED);
			} else {
				Printer::printString("Table is created!", Printer::ANSI_GREEN);
			}
		}

	}
}