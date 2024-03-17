<?php

namespace App\Core;

abstract class AbstractController
{
	public function testMsg($msg = ''): void
	{
		echo $msg;
	}
}