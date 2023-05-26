<?php

namespace Bisix21\src\Commands;

use Bisix21\src\Classes\Divider;
use Bisix21\src\Core\Converter;
use Bisix21\src\Core\GetConverter;
use Bisix21\src\Core\Validator;
use Bisix21\src\Interface\CommandInterface;
use Bisix21\src\Repository\DB;
use Bisix21\src\Repository\Files;
use Bisix21\src\UrlShort\Encode;
use InvalidArgumentException;

class EncodeCommand extends Command implements CommandInterface
{

	public function __construct(
		protected Encode    $encode,
		protected GetConverter $arguments,
		protected DB|Files  $record,
		protected Validator $validator
	)
	{
	}

	public function runAction(): void
	{
		//валідує лінк
		$this->validator->link($this->getArgument("url"));
		$this->issetCodeInDB();
		//записує в бд
		$this->saveAndPrint();
	}

	protected function issetCodeInDB()
	{
		$res = $this->validator->issetCode($this->encodeUrl());
		if (!$res) {
			throw new InvalidArgumentException("You have same record: {$this->encodeUrl()} => {$this->getArgument("url")}");
		}
	}

	protected function encodeUrl(): string
	{
		return $this->encode->encode($this->getArgument("url"));
	}

	protected function saveAndPrint()
	{
		$codeShort = $this->createArr($this->encodeUrl(), $this->getArgument("url"));
		$this->record->saveToDb($codeShort);
		Divider::printString($codeShort['code'] . " => " . $codeShort['url']);
	}

	protected function createArr(string $code, string $url): array
	{
		return [
			'code' => $code,
			'url' => $url,
		];
	}
}