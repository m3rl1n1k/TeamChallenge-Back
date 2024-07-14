<?php

namespace App\Repository;

use Core\DB\Model\AbstractModel;
use Core\DB\QueryBuilder\QueryBuilder;
use Exception;

class OrderItemRepository extends AbstractModel
{

    public function __construct(protected QueryBuilder $qb, protected ProductRepository $productRepository)
    {
        $this->table = 'order_items';
    }

    /**
     * @throws Exception
     */
    public function save(int $orderId, array $products): false|string
    {
        // find each product and add to array
        $orderList = $this->prepare($products);
        // prepare data before save
        foreach ($orderList as $key => $product) {
            $preparedData = [
                'order_id' => $orderId,
                'product_article' => $product['article'],
                'quantity' => $products[$product['article']]['quantity'],
                'price' => $product['price'],
            ];
            $this->insert($preparedData);
        }
        return $this->qb->pdo()->lastInsertId();

    }

    /**
     * @throws Exception
     */
    private function prepare(array $products): array
    {
        foreach ($products as $product) {
            $list[] = $this->productRepository->findBy(['article' => $product['article']]);
        }
        return $list;
    }
}