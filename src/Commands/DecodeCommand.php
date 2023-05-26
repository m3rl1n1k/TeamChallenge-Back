<?php

namespace Bisix21\src\Commands;

use Bisix21\src\Classes\Divider;
use Bisix21\src\Core\Converter;
use Bisix21\src\Core\Validator;
use Bisix21\src\Interface\CommandInterface;
use Bisix21\src\Repository\DB;
use Bisix21\src\Repository\Files;
use Bisix21\src\UrlShort\Decode;

class DecodeCommand  implements CommandInterface
{
	/**
	 * @param Decode $decoder
	 * @param DB|Files $record
	 * @param Converter $arguments
	 * @param Validator $validator
	 */
	public function __construct(
		protected Decode    $decoder,
		protected DB|Files  $record,
		protected Converter $arguments,
		protected Validator $validator
	)
	{
	}

	public function runAction(): void
	{
		$this->issetCodeInDB();
		Divider::printString($this->decoder->decode($this->arguments->getArguments()));
	}

	protected function issetCodeInDB(): void
	{
		$this->validator->isEmpty($this->record->read($this->arguments->getArguments()));
	}
}