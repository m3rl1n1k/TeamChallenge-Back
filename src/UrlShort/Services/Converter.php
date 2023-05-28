<?php

namespace Bisix21\src\UrlShort\Services;

class Converter
{
	protected string $command;
	protected string|array $arguments;

	public function __construct(
		protected Validator $validator,
		protected Request   $request
	)
	{
	}

	public function commandCall(): string
	{
		global $argv;
		$this->command = "help";
		if (!empty($argv)) {
			$argv = array_slice($argv, 1);
			$this->command = $this->prepareCommand($argv);
		}
		if (!empty($_GET)) {
			$this->command = $this->prepareCommand($this->request->getDataFromGetRequest()['command']);
		}
		return $this->command;
	}

	protected function prepareCommand($dataForCommand): array|string
	{
		if (!empty($dataForCommand)) {
			$dataForCommand = $this->validator->validateCommand($dataForCommand);
		}
		return $dataForCommand; //отримуємо команду
	}

	public function getArguments()
	{
		global $argv;
		$arguments = "";
		if (!empty($argv)) {
			$arguments = $this->prepareArgument($argv);
		}
		if (!empty($_GET)) {
			$arguments = $this->prepareArgument($this->request->getDataFromGetRequest());
		}
		return $arguments;

	}

	protected function prepareArgument($dataForArguments)
	{

		if (is_array($dataForArguments)) {
			if (!empty($dataForArguments)) {
				$dataForArguments = array_slice($dataForArguments, 1); // отримуємо аргументи (сайт або код)
				$dataForArguments = array_values($dataForArguments)[0];
			}
		}
		return $dataForArguments;
	}
}