<?php

namespace NewV;

use InvalidArgumentException;
use NewV\Interface\FilesInterface;

class Files implements FilesInterface
{
	protected string $pathUrls;
	protected string $pathLogs;

	/**
	 * @return string
	 */
	public function getPathLogs(): string
	{
		return $this->pathLogs;
	}

	/**
	 * @param string $pathLogs
	 */
	public function setPathLogs(string $pathLogs): void
	{
		$this->pathLogs = $pathLogs;
	}
	protected array $dataArray;
	/**
	 * @param string $pathUrls
	 */
	public function setPathUrls(string $pathUrls): void
	{
		$this->pathUrls = $pathUrls;
	}

	public function readFile(): array
	{
		if (!file_exists($this->pathUrls)) {
			file_put_contents($this->pathUrls, '');
			throw new InvalidArgumentException('File don\'t exist, rerun code');
		}
		$data = file_get_contents($this->pathUrls);
		return $this->dataArray = json_decode($data, true) ?? [];
	}

	public function saveToFile($data): void
	{
		if (!empty($data)) {
			$data = json_encode($data, JSON_PRETTY_PRINT);
			file_put_contents($this->pathUrls, $data);
		}

	}
}