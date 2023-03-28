<?php

namespace App\Controllers;

use Monolog\Logger;

class WorkWithFileController
{
	protected int $length;
	protected string $filePath;
	protected array $urls;
	protected Logger $logger;


	protected function loadUrlsFromFile(): void
	{
		if (file_exists($this->filePath)) {
			$data = file_get_contents($this->filePath);
			$this->urls = json_decode($data, true) ?? [];
		}
		$this->logger->log('info', 'Loaded URLs from file.');
	}

	protected function saveUrlsToFile(): void
	{
		$data = json_encode($this->urls, JSON_PRETTY_PRINT);
		file_put_contents($this->filePath, $data);
		$this->logger->log('info', 'Saved URLs to file.');
	}
}