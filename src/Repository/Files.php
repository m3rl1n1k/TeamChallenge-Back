<?php

namespace Bisix21\src\Repository;

use Bisix21\src\Interface\DBInterface;
use InvalidArgumentException;

class Files implements DBInterface
{
	protected array $dataArray;

	public function __construct(
		protected string $pathUrls
	)
	{
	}

	public function read(): array
	{
		if (!file_exists($this->pathUrls)) {
			file_put_contents($this->pathUrls, '');
			throw new InvalidArgumentException('File don\'t exist, rerun code');
		}
		$data = file_get_contents($this->pathUrls);
		return $this->dataArray = json_decode($data, true) ?? [];
	}

	public function saveToDB($data): void
	{
		dd($data);
		if (!empty($data)) {
			$data = json_encode($data, JSON_PRETTY_PRINT);
			file_put_contents($this->pathUrls, $data);
		}

	}
}