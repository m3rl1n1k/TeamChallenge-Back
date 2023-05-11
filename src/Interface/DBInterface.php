<?php

namespace  Bisix21\src\Interface;

use InvalidArgumentException;

interface DBInterface
{

	/**
	 * @throws InvalidArgumentException
	 * @return array
	 */
	public function read():array|null;

	/**
	 * @array $data
	 * @throws InvalidArgumentException
	 */
	public function saveToDB(array $data):void;

}