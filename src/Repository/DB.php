<?php

namespace Bisix21\src\Repository;

use Bisix21\src\Interface\DBInterface;
use Bisix21\src\Models\UrlShort;

class DB implements DBInterface
{
	public function __construct(protected UrlShort $short)
	{
	}

	public function saveToDb($data): void
	{
		$this->short->link = $data['url'];
		$this->short->code = $data['code'];
		$this->short->save();
	}

	public function read(): array
	{
		$urls = $this->short::all();
		foreach ($urls as $url) {
			$urlsNew[$url->code] = $url->link;
		}
		return $urlsNew;
	}
}