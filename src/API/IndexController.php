<?php

namespace App\API;

use App\Core\AbstractController;
use App\Core\Config;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
	public function index(): Response
	{
		return $this->json("Hello World!");
	}
	
	public function test($show): void
	{
		echo $show;
	}
	
}