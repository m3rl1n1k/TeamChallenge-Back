<?php

namespace Bisix21\src\UrlShort;

use Bisix21\src\Interface\IUrlDecoder;
use Bisix21\src\Models\UrlShort;


class Decode implements IUrlDecoder
{
	public function __construct(
		protected UrlShort $short
	)
	{
	}

	public function decode(string $code): string
	{
		$res = $this->short->getUrlByCode($code);
		return $res->url;
	}
}