<?php

namespace Core\Controller;

use Core\Config;
use Core\Exceptions\NotSendHeaders;
use Core\Helper\Printer;
use Core\Http\HttpStatusCode;
use Core\Http\Response;
use Throwable;

class ExceptionController extends AbstractController
{
	public function __construct()
	{
		@set_exception_handler([$this, 'handler']);
	}

	/**
	 * @throws NotSendHeaders
	 */
	public function handler(Throwable $e): Response
	{
		return new Response($this->mode($e), HttpStatusCode::BAD_REQUEST);
	}

	protected function mode($e)
	{
		return match (Config::getValue('config.mode')) {
			'dev' => $e->getMessage() . " " . $e->getLine() . " " . $e->getFile(),
			'prod' => $e->getMessage(),
		};
	}

	public function CLI_handler(): void
	{
		@set_exception_handler([$this, 'cli_exception']);
	}

	public function cli_exception(Throwable $e): void
	{
		$msg = $e->getMessage() . " " . $e->getFile() . " " . $e->getFile();
		Printer::printString($msg, Printer::ANSI_RED);
	}
}