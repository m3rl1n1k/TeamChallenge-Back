<?php

namespace Bisix21\src\UrlShort;

use Bisix21\src\Entity\Short;
use Bisix21\src\Interface\IUrlDecoder;
use Bisix21\src\Models\UrlShort;
use Doctrine\ORM\EntityManager;


class Decode implements IUrlDecoder
{
	public function __construct(
		protected EntityManager|UrlShort $short
	)
	{
	}

	public function decode(string $code): string
	{
//		$res = $this->short->getUrlByCode($code);
//		$url = $res->url;
		$shortRep = $this->short->getRepository(Short::class);
		$short = $shortRep->getUrlByCode($code);
		$url = $short->getUrl();

		return $url;
	}
}