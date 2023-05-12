<?php

namespace Bisix21\src\Commands;

use Bisix21\src\Classes\Divider;
use Bisix21\src\Core\Converter;
use Bisix21\src\Repository\DB;
use Bisix21\src\UrlShort\Decode;

class DecodeCommand extends Command
{
	public function __construct(
		protected Decode    $decoder,
		protected DB        $record,
		protected Converter $arguments,
	)
	{
	}

	public function runAction(): void
	{
		$urls = $this->record->read();
		$res = $this->decoder->setUrls($this->getAllUrls())->decode($this->getArgument());
		Divider::printString($res);
	}
}