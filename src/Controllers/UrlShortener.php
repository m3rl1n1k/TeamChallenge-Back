<?php

namespace Controllers;

use App\Controllers\LoggerInterface;
use InvalidArgumentException;

class UrlShortener implements IUrlEncoder
{
	private array $urls;
	private string $fileName;
	private int $length;
	private LoggerInterface $logger;

	public function __construct($fileName, LoggerInterface $logger)
	{
		$this->logger = $logger;
		$this->fileName = $fileName;
		$this->urls = $this->loadUrlsFromFile();
	}

	private function loadUrlsFromFile(): array
	{
		if (file_exists($this->fileName)) {
			$data = file_get_contents($this->fileName);
			$this->urls = json_decode($data, true) ?? [];
		} else {
			$this->urls = [];
		}
		return $this->urls;
	}

	/**
	 * @param int $length
	 */
	public function setLength(int $length): void
	{
		$this->length = $length;
	}

	private function getCodeFromUrl(string $url): string
	{
		return substr(md5($url), 0, $this->length);
	}

	private function saveUrlsToFile(): void
	{
		$data = json_encode($this->urls);
		file_put_contents($this->fileName, $data);
	}

	public function decode(string $code): ?string
	{
		$this->logger->log('info', 'Loaded URLs from file.');
		return $this->urls[$code] ?? null;
	}

	public function encode(string $url): string
	{
		if (!$this->isValidUrl($url)) {
			throw new InvalidArgumentException('Invalid URL.');
		}
		$code = $this->getCodeFromUrl($url);
		$this->urls[$code] = $url;
		$this->saveUrlsToFile();
		$this->logger->log('info', 'Saved URLs to file.');
		return substr(base64_encode(pack('H*', $code)), 0, $this->length);
	}

	private function isValidUrl(string $url): bool
	{
		if (!filter_var($url, FILTER_VALIDATE_URL)){
			http_response_code(400);
			throw new InvalidArgumentException('Invalid URL.');
		}
		return  http_response_code(200);
	}

}