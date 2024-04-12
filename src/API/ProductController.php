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
        $type = $params['type'];
        $limit = $params['limit'];
        $products = $this->product->getProductByType($type);
        return $this->response($products);
    }

    public function show($show): Response
    {
        //get variable with name from {variable} from address show/{variable}
        return $this->response($this->product->getSingle($show));
    }

    public function new($type, $request): Response
    {
        //get content from request body $request
        $product = $this->product->record($request, $type);
        return $this->response($product);
    }
}