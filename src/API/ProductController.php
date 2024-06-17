<?php

namespace App\API;

use App\Repository\Product;
use Core\Controller\AbstractController;
use Core\Exceptions\DuplicateRecordsException;
use Core\Http\HttpStatusCode;
use Core\Http\Response;
use Exception;

class ProductController extends AbstractController
{

	public function __construct(protected Product $product)
	{
	}

	/**
	 * @throws Exception
	 */
	public function index($params): Response
	{
		$products = $this->product->getAll($params);
		return $products ? new Response($products) : new Response('Not have more records!', HttpStatusCode::NOT_FOUND);
	}

	/**
	 * @throws Exception
	 */
	public function show($article): Response
	{
		$record = $this->product->findBy(['article' => $article]);
		$record['size'] = json_decode($record['size']);
		return $record ? new Response($record) : new Response('Fail', HttpStatusCode::NOT_FOUND);
	}

	/**
	 * @throws DuplicateRecordsException
	 */
	public function new($request): Response
	{
		$record = $this->product->save($request);
		return $record ? new Response("Created!") : new Response('Fail', HttpStatusCode::NOT_FOUND);
	}

	/**
	 * @throws Exception
	 */
	public function update($request, $article): Response
	{
		$this->product->update($request, $article);
		return new Response("Updated!");
	}

	/**
	 * @throws Exception
	 */
	public function delete($article): Response
	{
		$this->product->delete($article);
		return new Response("Deleted!");
	}
}