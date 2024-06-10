<?php

namespace App\API;

use Core\Controller\AbstractController;
use Core\Http\Response;

class IndexController extends AbstractController
{
	public function index()
	{
		new Response('Use Documentation for API!');
	}
}