<?php

namespace App\Tables;

use Core\StupidAR\Table;
use Core\StupidAR\TableTrait;

class Order_Items_table extends Table
{
    protected string $table = "order_items";
    protected array $fields = [
        "id" => "INT AUTO_INCREMENT PRIMARY KEY",
        "order_id" => "INT NOT NULL",
        "product_article" => "BIGINT NOT NULL",
        "quantity" => "INT NOT NULL",
        "price" => "DECIMAL(10, 2) NOT NULL",
        "created_at" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
        "updated_at" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
        "FOREIGN KEY (order_id) REFERENCES orders(id)",
        "CONSTRAINT FK_ProductID FOREIGN KEY (product_article) REFERENCES products(article)"
    ];
    use TableTrait;
}
