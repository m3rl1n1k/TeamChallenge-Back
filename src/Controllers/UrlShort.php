<?php

namespace NewV;

use InvalidArgumentException;
use NewV\Interface\FilesInterface;
use Psr\Log\LoggerInterface;


class UrlShort
{
	protected string $link, $code;
	protected array $urls;
	protected int $length;

	public function __construct(
		protected FilesInterface $file,
		protected LoggerInterface $logger,
		protected Validator $validator)
	{

		$this->urls = $this->file->readFile();

	}

	/**
	 * @param int $length
	 */
	public function setLength(int $length): void
	{
		$this->logger->info("Set length for code", ['length' => $length]);
		$this->length = $length;
	}

	/**
	 * @param string $code
	 * @return UrlShort
	 */
	public function setCode(string $code): static
	{
		$this->logger->info("Set code for decode", ['code' => $code]);
		$this->code = $code;
		return $this;
	}

	/**
	 * @param string $link
	 * @return UrlShort
	 */
	public function setLink(string $link): static
	{
		$this->logger->info("Set link for encode", ['link' => $link]);
		if (!$this->validator->link($link)) {
			$msg = "Invalid Url";
			$this->logger->error($msg, ['url' => $link]);
			throw new InvalidArgumentException($msg);
		}
		$this->link = $link;
		return $this;
	}

	public function encode(Encode $encode): void
	{
		$code = substr($encode->encode($this->link), 0, $this->length);
		$this->urls[$code] = $this->link;
		$this->file->saveToFile($this->urls);

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
		$this->logger->info("Get Urls", ['urls' => $this->urls]);
		return $this->urls;
	}

	public function decode(Decode $decode): void
	{
		$this->logger->info("Decode code", ['code' => $this->code]);
		$res = $decode->decode($this->code);
		new Divider('=', 60);
		Divider::printString("Your code: {$this->code} equal: $res");
	}

	public function individual(): static
	{
		$res = $this->validator->issetInDb($this->link, $this->urls);
		if ($res) {
			$msg = "Url is isset, his short-code is: " . $res;
			$this->logger->error($msg);
			throw new InvalidArgumentException($msg);
		}
		return $this;
	}
}