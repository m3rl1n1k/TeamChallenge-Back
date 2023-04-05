<?php

namespace NewV;

class UrlHandler
{
	public function __construct(
		protected Validator $validator,
		protected Files     $files,
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
		$urls = $this->getUrls();
		$this->validator->issetInDb($link, $urls);
		$urls[$code] = $link;
		$this->files->setPathUrls(CONFIG['Urls']);
		$this->files->saveToFile($urls);
	}

	public function getUrls(): array
	{
		return $this->files->readFile();
	}

	public function saveAny(string $code, $link): void
	{
		$urls = $this->getUrls();
		$urls[$code] = $link;
		$this->files->setPathUrls(CONFIG['Urls']);
		$this->files->saveToFile($urls);
	}
}