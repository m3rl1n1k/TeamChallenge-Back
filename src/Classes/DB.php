<?php

namespace Classes;

use Models\UrlShort;

class DB
{
	public function __construct(protected UrlShort $short)
	{
	}

	public  function saveToDb($code, $link){
		$this->short->url =$link;
		$this->short->code = $code;
		$this->short->save();
	}

	public function getRecord(): array
	{
		$urls = $this->short::all();
		foreach ($urls as $url) {
			$urlsNew[$url->code] = $url->url;
		}
		return $urlsNew;
	}
}