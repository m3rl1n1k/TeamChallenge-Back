<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use NewV\App;
use NewV\Decode;
use NewV\Encode;
use NewV\Files;
use NewV\Handler;
use NewV\Validator;

return  [
	App::class => function ($container) {
		return new  App(
			$container->get(Handler::class),
			$container->get(Encode::class),
			$container->get(Decode::class),
			$container->get(Logger::class),
		);
	},
	Encode::class => function () {
		return new Encode();
	},
	Decode::class => function () {
		return new Decode();
	},
	Logger::class => function ($container) {
		$log = new Logger("log");
		$log->pushHandler($container->get(StreamHandler::class));
		return $log;
	},
	StreamHandler::class => function () {
		return new StreamHandler(CONFIG['Logs']);
	},
	Handler::class => function ($container) {
		return new Handler(
			$container->get(Validator::class),
			$container->get(Files::class)
		);
	},
	Validator::class => function () {
		return new Validator();
	},
	Files::class => function () {
		return new Files();
	},
];