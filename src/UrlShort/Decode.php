<?php

namespace Bisix21\src\UrlShort;

use Bisix21\src\Interface\IUrlDecoder;
use http\Exception\InvalidArgumentException;


class Decode implements IUrlDecoder
{
	protected array $urls;

	/**
	 * @param array $urls
	 * @return Decode
	 */
	public function setUrls(array $urls): static
	{
		$this->urls = $urls;
		return $this;
	}

	public function decode(string $code): string
	{
		if (!$this->urls[$code]){
			throw new InvalidArgumentException(" Undefined code $code");
		}
		return $this->urls[$code];
	}
}