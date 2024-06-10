<?php

namespace Core\Http;

use Core\Exceptions\NotSendHeaders;
use Core\Interface\HeaderInterface;
use Override;

class Header implements HeaderInterface
{
	protected array $header;

	#[Override] public function setHeader(string $header, mixed $value): static
	{
		$this->header[$header] = $value;
		return $this;
	}

	#[Override] public function getHeaders(): array
	{
		return headers_list();
	}

	/**
	 * @throws NotSendHeaders
	 */
	#[Override] public function send(): void
	{
		if (!empty($this->header)) {
			if (headers_sent()) {
				throw new NotSendHeaders('Headers not be send!');
			}
			foreach ($this->header as $key => $header) {
				header("$key: $header");
			}
		}
	}
}