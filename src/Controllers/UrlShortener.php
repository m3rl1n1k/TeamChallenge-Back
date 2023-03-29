<?php

namespace Controllers;

use App\Controllers\LoggerInterface;
use App\Controllers\Validation;
use App\Controllers\WorkWithFileController as WwF;
use InvalidArgumentException;
use Monolog\Logger;

class UrlShortener extends WwF implements IUrlEncoder
{
	protected string $filePath;
	protected array $urls = [];
	protected int $length;
	protected Logger $logger;

	public function __construct($filePath, LoggerInterface $logger)
	{
		$this->logger = $logger;
		$this->filePath = $filePath;
		$this->loadUrlsFromFile();
	}

	protected function getCodeFromUrl(string $url): string
	{
		//перетворюємо в двійкову систему
		return substr(md5($url), 0, $this->length);
	}
	public function encode(string $url): string
	{
		if (!(new Validation())->isValidUrl($url)) {
			$this->logger->log('error', 'Invalid URL.');
			throw new InvalidArgumentException('Invalid URL.');
		}
		$this->logger->log('info', 'Valid URL');
		$code = $this->getCodeFromUrl($url);
		$this->urls[$code] = $url;
		$this->saveUrlsToFile();
			//створюєму унікальний id за допомогою хешу вхідних даних
		return substr( base64_encode(pack('H*', $code)), 0, $this->length);
	}

	public function decode(string $code): string
	{
		return $this->urls[$code];
	}

	/**
	 * @param int $length
	 */
	public function setLength(int $length): void
	{
		$this->length = $length;
	}
}