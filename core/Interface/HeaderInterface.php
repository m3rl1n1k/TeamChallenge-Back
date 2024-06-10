<?php

namespace Core\Interface;

interface HeaderInterface
{
	public function setHeader(string $header, mixed $value): static;

	public function getHeaders(): array;

	public function send();
}