<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use App\Repository\Product;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    public function __construct(protected Product $product)
    {
    }

    public function index($params): Response
    {
        $products = $this->product->getProductFrom($params['type']);
        return $this->response($products);
    }

    public function show($show): Response
    {
        //get variable with name from {variable} from address show/{variable}
        return $this->response($show);
    }

    public function new($request): Response
    {
        //get content from request body $request
        return $this->response($request);
    }
}