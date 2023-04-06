<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use NewV\App;
use NewV\Decode;
use NewV\Divider;
use NewV\Encode;
use NewV\Files;
use NewV\Handler;
use NewV\Validator;

require_once __DIR__ . "/../vendor/autoload.php";
define("CONFIG", require_once __DIR__ . "/../config/config.php");
try {
	$logger = new Logger('new_url_shorter');
	$logger->pushHandler(new StreamHandler(CONFIG['Logs']));

	$handler = new Handler(new Validator(), new Files());

	$app = new App($handler, new Encode(), new Decode(), $logger);
	$app->handle("https://github.com/Bisix21/php-lessons-pro/tree/main_rewrite", "081b05fcf7");
	echo "\n";
} catch (InvalidArgumentException $e) {
	Divider::printString($e->getMessage());
}

//вивід повідомлення
// якщо url не обов*язковий вивести тільки decode()
