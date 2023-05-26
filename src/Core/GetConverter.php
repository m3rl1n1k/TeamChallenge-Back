<?php

namespace Bisix21\src\Core;

use Bisix21\src\Classes\GetRequest;

class GetConverter extends Converter
{
	public function __construct(
		protected Validator $validator,
		protected GetRequest $getRequest
	)
	{
		parent::__construct($this->validator);
	}

	protected function prepareCommand(): string
	{
		return $this->getRequest->getDataFromGetRequest()['command'];
	}

	public function getArguments(): array
	{
		return $this->getRequest->getDataFromGetRequest();
	}

}