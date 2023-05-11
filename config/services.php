<?php

use Bisix21\src\Commands\DecodeCommand;
use Bisix21\src\Commands\EncodeCommand;
use Bisix21\src\Core\Command;
use Bisix21\src\Core\Config;
use Bisix21\src\Core\Converter;
use Bisix21\src\Core\Handler;
use Bisix21\src\Models\UrlShort;
use Bisix21\src\ORM\ActiveRecord;
use Bisix21\src\Repository\DB;
use Bisix21\src\Repository\Files;
use Bisix21\src\UrlShort\Decode;
use Bisix21\src\UrlShort\Encode;
use Bisix21\src\UrlShort\Validator;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

return [
	Handler::class => function ($container) {
		return new Handler(
			$container->get(Converter::class),
			$container->get(Command::class),
			$container->get(ActiveRecord::class)
		);
	},
	Converter::class => function () {
		return new Converter();
	},
	Encode::class => function ($container) {
		return new Encode(
			$container->get(Config::class)->get("config")["Length"]);
	},
	Command::class => function ($container) {
		return new Command(
			$container->get(Config::class)->get('commands')
		);
	},
	EncodeCommand::class => function ($container) {
		return new EncodeCommand(
			$container->get(Encode::class),
			$container->get(Converter::class),
			$container->get(DB::class),
			$container->get(Validator::class)
		);
	},
	Logger::class => function ($container) {
		$log = new Logger("log");
		$log->pushHandler($container->get(StreamHandler::class));
		return $log;
	},
	Decode::class => function () {
		return new Decode();
	},
	StreamHandler::class => function ($container) {
		return new StreamHandler($container->get(Config::class)->get("config")["Logs"]);
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
	},
	DecodeCommand::class => function ($container) {
		return new DecodeCommand(
			$container->get(Decode::class),
			$container->get(DB::class),
			$container->get(Converter::class)
		);
	},
];