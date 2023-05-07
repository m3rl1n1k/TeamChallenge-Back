<?php

namespace Classes;

use Interface\IUrlDecoder;
use Interface\IUrlEncoder;
use ORM\ActiveRecord;
use Psr\Log\LoggerInterface;

class App
{

	public function __construct(
		protected Handler         $handler,
		protected IUrlEncoder     $encoder,
		protected IUrlDecoder     $decoder,
		protected LoggerInterface $log,
		protected ActiveRecord $db,
	)
	{
		//
	}

	public function handle($link, $code): void
	{
		$this->log->info('Validate link', ['link' => $link]);

		$this->handler->validate($link);

		$this->log->info('Get all urls');

		$urls = $this->handler->getUrls();
		$res['encode'] = $this->encoder->encode($link);

		$this->log->info('Encoding', ['encode' => $res['encode']]);
		$this->log->info('Save to file');
		$this->log->info('Print result');

		$this->handler->save($res['encode'], $link);
		$res['decode'] = $this->decoder->setUrls($urls)->decode($code);
		$this->log->info('Decoding', ['decode' => $res['decode']]);

		Divider::printArray($res);
	}
}