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
        return $this->response($this->shoes->oneRecord($show));
    }

    public function new($request): Response
    {
        $record = $this->shoes->save($request);
        $response = $record ? "create successfully!" : "Error!";
        return $this->response($response);
    }

    public function update($id)
    {
        dd($id);
    }
}