<?php

namespace NewV;

use NewV\Interface\IUrlEncoder;


class Encode implements IUrlEncoder
{
	/**
	 * @inheritDoc
	 */
	public function encode(string $url): string
	{
		 return md5(mt_rand());
	}
}