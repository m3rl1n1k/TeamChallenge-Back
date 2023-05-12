<?php

namespace Bisix21\src\Commands;

use Bisix21\src\Classes\Divider;
use Bisix21\src\Core\Converter;
use Bisix21\src\Repository\DB;
use Bisix21\src\UrlShort\Encode;
use Bisix21\src\UrlShort\Validator;
use InvalidArgumentException;

class EncodeCommand extends Command
{

	public function __construct(
		protected Encode    $encode,
		protected Converter $arguments,
		protected DB        $record,
		protected Validator $validator
	)
	{
	}

	public function runAction(): void
	{
		$this->validator->link($this->getArgument());
		$this->emptyUrls();
		$this->issetUrlInDB();
	}

	protected function emptyUrls()
	{
		$res = $this->createArr($this->encodeUrl(), $this->getArgument());
		if (empty($this->getAllUrls())) {
			$this->record->saveToDb($res);
		}
		Divider::printString($res['code'] . " => " . $res['url']);
	}

	protected function createArr(string $code, string $link): array
	{
		return [
			'code' => $code,
			'url' => $link,
		];
	}

	protected function encodeUrl(): string
	{
		return $this->encode->encode($this->getArgument());
	}
		protected function issetUrlInDB()
	{
		$res = $this->validator->issetIn($this->getArgument(), $this->getAllUrls());
		if ($res) {
			$res = $this->createArr($this->encodeUrl(), $this->getArgument());
			$this->record->saveToDb($res);
		} else {
			throw new InvalidArgumentException("You have same record: {$this->encodeUrl()} => {$this->getArgument()}");
		}
	}
}