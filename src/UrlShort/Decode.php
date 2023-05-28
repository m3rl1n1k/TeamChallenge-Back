<?php

namespace Bisix21\src\UrlShort;

use Bisix21\src\UrlShort\Entity\Short;
use Bisix21\src\UrlShort\Interface\IUrlDecoder;
use Bisix21\src\UrlShort\Models\UrlShort;
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
		return $this->decodeFromDM($code);
	}
	protected function decodeFromDM(string $code)
	{
		$shortRep = $this->short->getRepository(Short::class);
		$short = $shortRep->getUrlByCode($code);
		return $short->getUrl();
	}

	protected function decodeFromAR(string $code)
	{
		$res = $this->short->getUrlByCode($code);
		return $res->url;
	}
}