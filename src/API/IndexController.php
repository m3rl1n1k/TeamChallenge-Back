<?php

namespace App\API;

use App\Core\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{

	public function index(): Response
	{
		return $this->json(
			"Hello world!"
		);
	}
	
	public function test($show ): void
	{
		//get variable with name from {variable} from address show/{variable}
	}
	
	public function new($request)
	{
		//get content from request body $request
		return$this->json($request);
	}
	
}