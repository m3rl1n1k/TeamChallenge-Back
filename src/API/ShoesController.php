<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use App\Repository\Shoes;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ShoesController extends AbstractController
{

    public function __construct(protected Shoes $shoes)
    {
    }

    /**
     * @throws Exception
     */
    public function index($params): Response
    {
        $products = $this->shoes->getAll($params);
        return $this->response($products);
    }

    /**
     * @throws Exception
     */
    public function show($show): Response
    {
        return $this->response($this->shoes->oneRecord($show));
    }

    /**
     * @throws Exception
     */
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