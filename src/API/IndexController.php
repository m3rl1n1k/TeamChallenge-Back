<?php

namespace App\API;

use App\Core\AbstractController;
use App\Core\Config;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
	public function index($id):Response
	{
		return $this->json($id);
	}
	public function test():Response
	{
		$db = Config::instance()->get('database');
		return $this->json($db);
	}
}