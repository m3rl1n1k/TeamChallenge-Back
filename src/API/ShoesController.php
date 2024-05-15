<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use App\Core\HttpStatusCode;
use App\Core\Request;
use App\Repository\Shoes;
use Exception;

class ShoesController extends AbstractController
{

    public function __construct(protected Shoes $shoes, protected Request $re)
    {
    }

    /**
     * @throws Exception
     */
    public function index($params): void
    {
        $products = $this->shoes->getAll($params);
        $products ? $this->response($products, HttpStatusCode::OK) : $this->response('Fail', HttpStatusCode::NOT_FOUND);
    }

    /**
     * @throws Exception
     */
    public function show($show)
    {
        $data = $this->shoes->oneRecord($show);
        $this->response($data, HttpStatusCode::OK);
    }

    /**
     * @throws Exception
     */
    public function new($request)
    {
        $record = $this->shoes->save($request);
        $record ? $this->response("Created successfully", HttpStatusCode::CREATED) : $this->response('Fail', HttpStatusCode::BAD_REQUEST);
    }

    /**
     * @throws Exception
     */
    public function update($request, $article)
    {
        $record = $this->shoes->saveUpdate($request, $article);
        $record ? $this->response("Updated successfully", HttpStatusCode::OK) : $this->response('Fail', HttpStatusCode::BAD_REQUEST);
    }
}