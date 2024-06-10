<?php

use Core\Config;
use Core\Container\Container;
use Core\Controller\ExceptionController;

require_once "../vendor/autoload.php";


/** @var ExceptionController $eHandler */
Container::call(ExceptionController::class);
// map configs
Config::instance(
	array_merge(
		[
			'database' => require_once "../config/database.php",
			'config' => require "../config/config.php",
			'headers' => require "../config/headers.php",
			'middleware' => require "../config/middleware.php",
		]
	)
);