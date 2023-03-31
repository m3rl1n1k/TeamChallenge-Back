<?php

namespace Controllers;

class WorkWithFile
{
	private string $filePath;

	public function __construct($filePath)
	{
		$this->filePath = $filePath;
	}

	public function loadUrlsFromFile(): array
	{
		if (file_exists($this->filePath)) {
			$data = file_get_contents($this->filePath);
			return $urls = json_decode($data, true) ?? [];
		}
		return [];
	}

	public function saveUrlsToFile($url): void
	{
		$data = json_encode($url, JSON_PRETTY_PRINT);
		file_put_contents($this->filePath, $data);

	}
}