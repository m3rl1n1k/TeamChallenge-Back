<?php

use DI\Config;

require_once ROOT . "vendor/autoload.php";

Config::instance(
	array_merge([
			"services" => require_once ROOT . "config/services.php",
			"config" => require_once ROOT . "config/config.php"
		]
	)
);
