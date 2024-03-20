<?php

namespace App\API;

use App\Core\AbstractController;
use App\Core\Config;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
	public function index():Response
	{
		$db = Config::instance()->get('database');
		return $this->json($db);
	}
}