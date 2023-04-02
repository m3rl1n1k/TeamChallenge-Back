<?php

namespace NewV;

use Config\Config;
use NewV\Interface\IUrlEncoder;


class Encode implements IUrlEncoder
{
	/**
	 * @inheritDoc
	 */
	public function encode(string $url): string
	{
		 return substr(md5(mt_rand()), 0, Config::LENGTH);
	}
}