<?php

namespace Core\Interface;

interface RequestInterface
{
	public function getUrl(): string;

	public function getMethod(): string;

}