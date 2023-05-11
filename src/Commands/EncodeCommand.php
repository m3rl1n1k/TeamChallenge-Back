<?php

namespace Bisix21\src\Commands;

use Bisix21\src\Classes\Divider;
use Bisix21\src\Core\Converter;
use Bisix21\src\Interface\CommandInterface;
use Bisix21\src\Repository\DB;
use Bisix21\src\UrlShort\Encode;
use Bisix21\src\UrlShort\Validator;
use InvalidArgumentException;

class EncodeCommand implements CommandInterface
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
		$link = $this->arguments->getArguments()[0];
		$code = $this->encode->encode($link);
		$urls = $this->record->read();
		$this->validator->link($link);
		if (empty($urls)) {
			$res = [
				'code' => $code,
				'url' => $link,
			];
			$this->record->saveToDb($res);
			Divider::printString($res['code'] . "=>" . $res['url']);
		}
		$res = $this->validator->issetIn($link, $urls);
		if ($res) {
			$res = [
				'code' => $code,
				'url' => $link,
			];
			$this->record->saveToDb($res);
		} else {
			throw new InvalidArgumentException("You have same record: $code => $link");
		}
		Divider::printString($res['code'] . "=>" . $res['url']);
	}
}