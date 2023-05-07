<?php

namespace Classes;

use InvalidArgumentException;

class Validator
{
	public function link($link): bool|int
	{
		// прротокол + доменна назва . домен : порт(якщо існує)/ назва каталогу
		$pattern = '/^https?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})(:[0-9]{1,5})?(\/.*)?$/i';
		$res = preg_match($pattern, $link);
		if (!$res) {
			throw new InvalidArgumentException('Invalid url');
		}
		return $res;
	}

	public function issetIn($value, $array): bool
	{
		if (array_search($value, $array)){
			return false;
		}
		return true;
	}

}