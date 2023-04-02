<?php

namespace NewV;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;


class UrlShort
{
	protected string $filePath, $link, $code;
	protected array $urls;
	protected LoggerInterface $logger;
	private Encode $encode;
	private Decode $decode;

	public function __construct($filePath, LoggerInterface $logger)
	{
		$this->filePath = $filePath;
		$this->logger = $logger;
		$this->urls = (new Files($this->filePath))->readFile();;
		$this->encode = new Encode();
		$this->decode = new Decode($this->urls);
	}

	/**
	 * @param string $code
	 * @return UrlShort
	 */
	public function setCode(string $code): static
	{
		$this->logger->info('Set code for decode', ['code' => $code]);
		$this->code = $code;
		return $this;
	}

	/**
	 * @param string $link
	 * @return UrlShort
	 */
	public function setLink(string $link): static
	{
		$this->logger->info('Set link for encode', ['link' => $link]);
		if (!(new Validator($link))->link()) {
			$msg = "Invalid Url";
			$this->logger->error($msg, ['url' => $link]);
			throw new InvalidArgumentException($msg);
		}
		$this->link = $link;
		return $this;
	}

	public function encode(): void
	{
		$this->urls[$this->encode->encode($this->link)] = $this->link;
		(new Files($this->filePath))->saveToFile($this->urls);
	}

	public function showUrls(): void
	{
		new Divider('=', 32);
		Divider::printArray($this->getUrls());
	}

	/**
	 * @return array
	 */
	public function getUrls(): array
	{
		$this->logger->info('Get Urls');
		return $this->urls;
	}

	public function decode(): void
	{
		$this->logger->info('Decode code', ['code' => $this->code]);
		$res = $this->decode->decode($this->code);
		new Divider('=', 60);
		Divider::printString("Your code: {$this->code} equal: $res");
	}
}