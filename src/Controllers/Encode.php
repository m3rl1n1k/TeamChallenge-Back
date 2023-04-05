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
		 return substr( md5($url), 0 , CONFIG['Length']);
	}

	public function encodeAny(): string
	{
		return substr(md5(mt_rand()), 0 , CONFIG['Length']);
	}
}