<?php

namespace App\API;


use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Service\OrderService;
use Core\Http\HttpStatusCode;
use Core\Http\Response;
use Exception;

class OrderController
{
    public function __construct(
        protected ProductRepository $product,
        protected OrderService      $orderService,
        protected OrderRepository   $orderRepository,)
    {
    }

    /**
     * @throws Exception
     */
    public function createOrder($request)
    {

        $status = $this->orderService->createOrder($request);

        return $status ? new Response("Order created", HttpStatusCode::CREATED) : new Response("Failed to create order", HttpStatusCode::BAD_REQUEST);


    }

//    protected function prepare(array $products): array
//    {
//        foreach ($products as $key => $product) {
//            $products[$key] = $this->getProduct($product['article']);
//        }
//        return $products;
//    }
//
//    /**
//     * @throws Exception
//     */
//    private function getProduct(int $article)
//    {
//        $product = $this->product->findBy(['article' => $article]);
//        $product['size'] = json_decode($product['size'], true);
//        return $product;
//    }
}