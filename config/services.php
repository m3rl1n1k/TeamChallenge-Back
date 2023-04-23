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
	Encode::class => function ($container) {
		return new Encode($container->get(Config::class)->get("config")["Length"]);
	},
	Decode::class => function () {
		return new Decode();
	},
	Logger::class => function ($container) {
		$log = new Logger("log");
		$log->pushHandler($container->get(StreamHandler::class));
		return $log;
	},
	StreamHandler::class => function ($container) {
		return new StreamHandler($container->get(Config::class)->get("config")["Logs"]);
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
	Files::class => function ($container) {
		return new Files($container->get(Config::class)->get("config")["Urls"]);
	},
	Config::class => function () {
		return Config::instance();
	}
];