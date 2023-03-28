<?php

namespace App\Controllers;

class WorkWithFileController
{
	protected int $length;
	protected string $filePath;
	protected array $urls;


	protected function getCodeFromUrl(string $url): string
	{
		//перетворюємо в двійкову систему
		return substr(md5($url), 0, $this->length);
	}

	protected function loadUrlsFromFile(): array
	{
		if (file_exists($this->filePath)) {
			$data = file_get_contents($this->filePath);
			$this->urls = json_decode($data, true) ?? [];
		}
		return $this->urls;
	}

	protected function saveUrlsToFile(): void
	{
		$data = json_encode($this->urls, JSON_PRETTY_PRINT);
		file_put_contents($this->filePath, $data);
	}
}