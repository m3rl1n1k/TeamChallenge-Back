<?php

namespace Bisix21\src\UrlShort\Repository;

use Bisix21\src\UrlShort\Interface\DBInterface;
use InvalidArgumentException;

class Files implements DBInterface
{
	protected array $dataArray;

	public function __construct(
		protected string $pathUrls
	)
	{
		$this->dataArray = $this->getData();
	}

	protected function getData(): array
	{
		$data = file_get_contents($this->pathUrls);
		return json_decode($data, true);
	}

	public function read(string $code): string|null
	{
		if (!file_exists($this->pathUrls)) {
			file_put_contents($this->pathUrls, '');
			throw new InvalidArgumentException('File don\'t exist, rerun code');
		}
		return $this->dataArray[$code];
	}

	public function saveToDB($data): void
	{
		$this->dataArray[$data['code']] = $data['url'];
		if (!empty($data)) {
			$data = json_encode($this->dataArray, JSON_PRETTY_PRINT);
			file_put_contents($this->pathUrls, $data);
		}
	}
}