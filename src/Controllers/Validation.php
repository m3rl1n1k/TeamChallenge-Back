<?php

namespace App\Controllers;

class Validation
{
	public function isValidUrl(string $url): bool
	{
		return filter_var($url, FILTER_VALIDATE_URL) !== false;
	}
}