<?php

namespace Core\Interface;

interface ResponseInterface
{
	public function setStatusCode(int $code): void;

	public function getStatusCode(): int;
}