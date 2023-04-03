<?php

namespace NewV;

use InvalidArgumentException;

class Validator
{
	public static function link($link): bool|int
	{
		if (empty(trim($link))) {
			throw new InvalidArgumentException('Url is empty');
		}
		// прротокол + доменна назва . домен : порт(якщо існує)/ назва каталогу
		$pattern = '/^https?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})(:[0-9]{1,5})?(\/.*)?$/i';
		return preg_match($pattern, $link);
	}

	public function issetInDb($value, $array): bool|string
	{
		return array_search($value,$array);
	}
}