<?php

namespace NewV\Interface;

use InvalidArgumentException;

interface FilesInterface
{

	/**
	 * @throws InvalidArgumentException
	 * @return array
	 */
	public function readJsonFile():array;

	/**
	 * @array $data
	 * @throws InvalidArgumentException
	 */
	public function saveToFile(array $data):void;

}