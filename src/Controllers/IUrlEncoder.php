<?php

namespace Controllers;

use InvalidArgumentException;

interface IUrlEncoder extends IUrlDecoder
{

	/**
	 * @param string $url
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public function encode(string $url): string;
}

