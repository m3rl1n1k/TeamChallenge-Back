<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use App\Core\HttpStatusCode;
use App\Core\Request;
use App\Repository\Shoes;
use Exception;

class ShoesController extends AbstractController
{

    public function __construct(protected Shoes $shoes)
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
    public function show($show): void
    {
        $record = $this->shoes->find($show);
        $record['size'] = json_decode($record['size']);
        $this->response($record, HttpStatusCode::OK);
    }

    /**
     * @throws Exception
     */
    public function new($request): void
    {
        $record = $this->shoes->save($request);
        $record ? $this->response("Created successfully", HttpStatusCode::CREATED) : $this->response('Fail', HttpStatusCode::BAD_REQUEST);
    }

    /**
     * @throws Exception
     */
    public function update($request, $article): void
    {
        $this->shoes->update($request, $article);
        $this->response("Updated successfully", HttpStatusCode::OK);
    }

    /**
     * @throws Exception
     */
    public function delete($article): void
    {
        $this->shoes->delete($article);
        $this->response("Deleted!", HttpStatusCode::OK);
    }
}