<?php

namespace NewV;

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

	public function issetInDb($value, $array): void
	{
		$res = array_search($value, $array);
		if ($res) {
			throw new InvalidArgumentException("You have same record: $res => $value");
		}
	}

}