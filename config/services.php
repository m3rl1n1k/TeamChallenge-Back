<?php

use Classes\App;
use Classes\DB;
use Classes\Decode;
use Classes\Encode;
use Classes\Files;
use Classes\Handler;
use Classes\Validator;
use DI\Config;
use Models\UrlShort;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use ORM\ActiveRecord;

return [
	App::class => function ($container) {
		return new  App(
			$container->get(Handler::class),
			$container->get(Encode::class),
			$container->get(Decode::class),
			$container->get(Logger::class),
			$container->get(ActiveRecord::class),
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
			$container->get(Files::class),
			$container->get(DB::class)
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
	},
	ActiveRecord::class => function ($container) {
		$configDbConnection = $container->get(Config::class)->get("config")['db_connection'];
		return new ActiveRecord($configDbConnection);
	},
	UrlShort::class => function () {
		return new UrlShort();
	},
	DB::class => function ($container) {
		return new DB($container->get(UrlShort::class));
	}
];