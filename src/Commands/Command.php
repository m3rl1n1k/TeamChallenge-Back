<?php

namespace Bisix21\src\Commands;

abstract class Command
{
protected function getDataForArgumets()
{
  //передаємо дані для отримання аргументів  
}
	protected function getArgument($key)
	{
		return $this->arguments->getArguments(
    $giveDataForArgument
  );
	}
}