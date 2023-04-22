<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use NewV\App;
use NewV\Config;
use NewV\Decode;
use NewV\Encode;
use NewV\Files;
use NewV\Handler;
use NewV\Validator;

return [
	App::class => function ($container) {
		return new  App(
			$container->get(Handler::class),
			$container->get(Encode::class),
			$container->get(Decode::class),
			$container->get(Logger::class),
		);
	},
	Encode::class => function () {
		$length = Config::instance()->get("config")["Length"];
		return new Encode($length);
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
		$log = Config::instance()->get("config")["Logs"];
		return new StreamHandler($log);
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
		$urls = Config::instance()->get('config')["Urls"];
		return new Files($urls);
	},
];