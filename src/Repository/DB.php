<?php

namespace Bisix21\src\Repository;

use Bisix21\src\Interface\DBInterface;
use Bisix21\src\Models\UrlShort;
use InvalidArgumentException;

class DB implements DBInterface
{
	public function __construct(protected UrlShort $short)
	{
	}

	public function saveToDb($data): void
	{

		$this->short->code = $data['code'];
		$this->short->url = $data['url'];
		$this->short->save();
	}

	public function read(string $code): string|null
	{
		$res = $this->short->getUrlByCode($code);
		if (!$res) {
			throw new InvalidArgumentException(" Undefined code: $code");
		}
		return $res->url;
	}
}