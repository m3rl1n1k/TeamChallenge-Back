<?php

namespace App\Service;

use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use DiggPHP\Psr11\NotFoundException;
use Exception;
use LogicException;

class OrderService
{
    public function __construct(
        protected OrderRepository     $orderRepository,
        protected ProductRepository   $productRepository,
        protected OrderItemRepository $orderItemRepository,
        protected UserRepository      $user)
    {
    }

    /**
     * @throws Exception
     */
    public function createOrder(array $orderData): bool
    {
        // prepare order data
        $order = $orderData['order'];
        $totalPrice = $order['total_price'];
        $products = $order['products'];
        // update each product
        $this->updateProduct($products);
        // create order in table with data (total_price, user_id, status, order_date)
        $id = $this->user->save($orderData['recipient']);
        //
        $preparedOrderData = [
            'user_id' => $id,
            'total_price' => $totalPrice,
            'status' => 0,
            'payment_method' => $this->paymentMethod($orderData['payment_data']['payment_method'])
        ];
        // save order
        $this->orderRepository->save($preparedOrderData);
        // get order ID
        $orderId = $this->orderRepository->getLastInsertId();
        // create order_item record for each product with (order_id, quantity, price,  etc.)

        return $this->orderItemRepository->save($orderId, $products);
    }

    /**
     * @throws Exception
     */
    protected function updateProduct(mixed $products): void
    {
        foreach ($products as $product) {
            $preparedProduct = $this->productRepository->findBy(['article' => $product['article']]);
            // get all  data about product for prepare their before update
            $preparedProduct = array_merge($preparedProduct, [
                'order_quantity' => $product['quantity'],
                'order_size' => $product['size'],
            ]);
            // minus quantity in product
            $product = $this->calculate($preparedProduct);
            $this->productRepository->update($product, $product['article']);
        }
    }

    private function calculate(array $product): array
    {

        $size = $product['order_size'];
        $quantity = $product['order_quantity'];
        $sizeQuantity = json_decode($product['size'])->$size;


        if ($product['quantity'] == 0) {
            throw new LogicException("Quantity not enough for product with article: {$product['article']}");
        }
        if ($quantity > $sizeQuantity) {
            throw new LogicException("Quantity not enough for product with article {$product['article']} for size '$size'.");
        }

        //	-> set quantity product to -1
        $product['quantity'] = $product['quantity'] - 1;
        $product['size'] = json_encode([
            $size => json_decode($product['size'])->$size - 1
        ]);
        unset(
            $product['order_size'],
            $product['order_quantity'],
        );
        return $product;

    }

    /**
     * @throws NotFoundException
     */
    private function paymentMethod(mixed $payment_method): int
    {
        return match ($payment_method) {
            'card' => 1,
            'google_pay' => 2,
            'apple_pay' => 3,
            'cash' => 4,
            default => throw new NotFoundException('Method not found')
        };
    }
}