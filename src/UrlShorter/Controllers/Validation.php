<?php

namespace App\Controllers;

class Validation
{
	public function isValidUrl(string $url): bool
	{
		// прротокол + доменна назва . домен : порт(якщо існує)/ назва каталогу
		$pattern = '/^https?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})(:[0-9]{1,5})?(\/.*)?$/i';
		return preg_match($pattern, $url);
	}
}