<?php

namespace Controllers;

use App\Controllers\LoggerInterface;
use App\Controllers\Validation;
use App\Controllers\WorkWithFile;
use InvalidArgumentException;
use Monolog\Logger;

class UrlShortener implements IUrlEncoder, IUrlDecoder
{
	protected string $filePath;
	protected array $urls;
	protected int $length;
	protected Logger $logger;
	protected WorkWithFile $wwf;

	public function __construct($filePath, LoggerInterface $logger)
	{
		$this->logger = $logger;
		$this->wwf = new WorkWithFile($filePath);
		$this->filePath = $filePath;
		$this->logger->log('info', 'Loaded URLs from file.');
		$this->urls = $this->wwf->loadUrlsFromFile();

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
		$this->wwf->saveUrlsToFile($this->urls);
		$this->logger->log('info', 'Saved URLs to file.');
		//створюєму унікальний id за допомогою хешу вхідних даних
		return substr(base64_encode(pack('H*', $code)), 0, $this->length);
	}

	protected function getCodeFromUrl(string $url): string
	{
		//перетворюємо в двійкову систему
		return substr(md5($url), 0, $this->length);
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