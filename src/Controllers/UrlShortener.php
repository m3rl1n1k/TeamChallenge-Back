<?php

namespace Controllers;

use App\Controllers\Validation;
use App\Controllers\WorkWithFileController as WwF;
use InvalidArgumentException;

class UrlShortener extends WwF implements IUrlEncoder
{
	protected string $filePath;
	protected array $urls = [];
	protected int $length;

	public function __construct($filePath)
	{
		$this->filePath = $filePath;
		$this->urls = $this->loadUrlsFromFile();
	}

	public function encode(string $url): string
	{
		if (!(new Validation())->isValidUrl($url)) {
			throw new InvalidArgumentException('Invalid URL.');
		}
		$code = $this->getCodeFromUrl($url);
		$this->urls[$code] = $url;
		$this->saveUrlsToFile();
			//створюєму фнкальний id за допомогою хешу вхідних даних
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