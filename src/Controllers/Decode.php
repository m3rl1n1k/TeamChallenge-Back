<?php

namespace NewV;



use NewV\Interface\IUrlDecoder;

class Decode implements IUrlDecoder
{
	protected array $urls;

	public function __construct($urls)
	{
		$this->urls = $urls;
	}

	public function decode(string $code): string
	{
		return $this->urls[$code];
	}
}