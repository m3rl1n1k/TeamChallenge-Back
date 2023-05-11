<?php

namespace Bisix21\src\Commands;

use Bisix21\src\Classes\Divider;
use Bisix21\src\Core\Converter;
use Bisix21\src\Interface\CommandInterface;
use Bisix21\src\Repository\DB;
use Bisix21\src\UrlShort\Decode;

class DecodeCommand implements CommandInterface
{
	public function __construct(
		protected Decode    $decoder,
		protected DB        $short,
		protected Converter $arguments,
	)
	{
	}

	public function runAction(): void
	{
		$code = $this->arguments->getArguments()[0];
		$urls = $this->short->read();
		$res = $this->decoder->setUrls($urls)->decode($code);
		Divider::printString($res);
	}
}