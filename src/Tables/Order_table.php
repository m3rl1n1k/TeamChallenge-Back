<?php

namespace App\Tables;

use Core\StupidAR\Table;
use Core\StupidAR\TableTrait;

class Order_table extends Table
{
	protected string $table = "orders";
	protected array $fields = [
		'id INT AUTO_INCREMENT PRIMARY KEY',
		'user_id INT NOT NULL',
		'product_article BIGINT NOT NULL',
		'quantity INT NOT NULL',
		'price DECIMAL(10, 2) NOT NULL',
		'status INT NOT NULL DEFAULT 0',
		'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
		'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',

		'CONSTRAINT FK_UserID FOREIGN KEY (user_id) REFERENCES user(id)',
		'CONSTRAINT FK_ProductOrder FOREIGN KEY (product_article) REFERENCES product(article)',
	];

	use TableTrait;
}