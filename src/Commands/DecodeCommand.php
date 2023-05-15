<?php

namespace Bisix21\src\Commands;

use Bisix21\src\Classes\Divider;
use Bisix21\src\Core\Converter;
use Bisix21\src\Interface\CommandInterface;
use Bisix21\src\Repository\DB;
use Bisix21\src\Repository\Files;
use Bisix21\src\UrlShort\Decode;

class DecodeCommand extends Command implements CommandInterface
{
	/**
	 * @param Decode $decoder
	 * @param DB|Files $record
	 * @param Converter $arguments
	 */
	public function __construct(
		protected Decode    $decoder,
		protected DB|Files  $record,
		protected Converter $arguments,
	)
	{
	}

	public function runAction(): void
	{
		$res = $this->decoder->setUrls($this->getAllUrls())->decode($this->getArgument());
		Divider::printString($res);
	}
}