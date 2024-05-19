<?php

namespace App\API;

use App\Core\Controller\AbstractController;
use App\Core\Exceptions\DuplicateRecordsException;
use App\Core\Http\HttpStatusCode;
use App\Core\Http\Response;
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
    public function index($params): Response
    {
        $products = $this->shoes->getAll($params);
        return $products ? new Response($products) : new Response('Not have more records!', HttpStatusCode::NOT_FOUND);
    }

    /**
     * @throws Exception
     */
    public function show($show): Response
    {
        $record = $this->shoes->findBy(['article' => $show]);
        $record['size'] = json_decode($record['size']);
        return $record ? new Response($record) : new Response('Fail', HttpStatusCode::NOT_FOUND);
    }

    /**
     * @throws DuplicateRecordsException
     */
    public function new($request): Response
    {
        $record = $this->shoes->save($request);
        return $record ? new Response("Created!") : new Response('Fail', HttpStatusCode::NOT_FOUND);
    }

    /**
     * @throws Exception
     */
    public function update($request, $article): Response
    {
        $this->shoes->update($request, $article);
        return new Response("Updated!");
    }

    /**
     * @throws Exception
     */
    public function delete($article): Response
    {
        $this->shoes->delete($article);
        return new Response("Deleted!");
    }
}