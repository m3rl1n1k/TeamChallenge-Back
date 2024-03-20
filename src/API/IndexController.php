<?php

namespace App\API;

use App\Core\AbstractController;
use App\Core\Config;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
	public function index($id):Response
	{
		$db = Config::instance()->get('database');
		return $this->json($id);
	}
}