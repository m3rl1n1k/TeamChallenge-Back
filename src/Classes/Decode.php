<?php

namespace Classes;

use http\Exception\InvalidArgumentException;
use Interface\IUrlDecoder;

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