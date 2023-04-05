<?php

namespace NewV;

use NewV\Interface\IUrlDecoder;

class Decode implements IUrlDecoder
{
	protected array $urls;

	/**
	 * @param array $urls
	 */
	public function setUrls(array $urls): static
	{
		$this->urls = $urls;
		return $this;
	}

	public function decode(string $code): string
	{
		return $this->urls[$code];
	}
}