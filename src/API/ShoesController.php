<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use App\Repository\Shoes;
use Symfony\Component\HttpFoundation\Response;

class ShoesController extends AbstractController
{

    public function __construct(protected Shoes $shoes)
    {
    }

    public function index($params): Response
    {
        $products = $this->shoes->setSort($params['sort'])->setLimit($params['limit'])->getAll();
        return $this->response($products);
    }

    public function show($show): Response
    {
        //get variable with name from {variable} from address show/{variable}
        return $this->response($this->shoes->find($show));
    }

    public function new($type, $request): Response
    {
        //get content from request body $request
        $product = $this->shoes->save($request, $type);
        return $this->response($product);
    }
}