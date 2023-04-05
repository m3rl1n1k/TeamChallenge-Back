<?php

namespace NewV;

use NewV\Interface\IUrlDecoder;
use NewV\Interface\IUrlEncoder;
use Psr\Log\LoggerInterface;

class App
{

	public function __construct(
		protected UrlHandler      $urlHandler,
		protected IUrlEncoder     $encoder,
		protected IUrlDecoder     $decoder,
		protected LoggerInterface $log,
	)
	{
		//
	}

	public function handle($link = "", $code = ""): void
	{
		$this->urlHandler->validate($link);
		$urls = $this->urlHandler->getUrls();
		$res['encode'] = $this->encoder->encode($link);
		$this->urlHandler->save($res['encode'], $link);
		$res['decode'] = $this->decoder->setUrls($urls)->decode($code);
		Divider::printArray($res);
	}
}