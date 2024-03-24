<?php

namespace App\Core;

use JsonException;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends Response
{
	public function json($data, $format = 'json')
	{
			if ($format === 'json') {
				$json = json_encode($data);
				$this->headers($json);
			}
			if ($format === 'array') {
				return json_decode($data, true);
			}
			return new Response();
	}
	
	protected function headers($content): void
	{
		$this->headers->set('Content-Type', 'application/json');
		$this->headers->set('Access-Control-Allow-Origin', '*');
		$this->setContent($content);
		$this->send();
	}
}