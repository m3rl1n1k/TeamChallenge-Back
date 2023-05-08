<?php

namespace Classes;

use InvalidArgumentException;
use Models\UrlShort;

class Handler
{
	public function __construct(
		protected Validator $validator,
		protected Files     $files,
		protected Url       $record,
	)
	{
		//
	}

	public function validate($link): void
	{
		$this->validator->link($link);
	}

	public function save(string $code, $link): void
	{
		$urls = $this->record->getRecord();
		$res = $this->validator->issetIn($link, $urls);
		if ($res)
			$this->record->saveToDb($code, $link);
		else
			throw new InvalidArgumentException("You have same record: $code => $link");
	}

	public function getUrls(): array
	{
		return $this->files->readFile();
	}
}