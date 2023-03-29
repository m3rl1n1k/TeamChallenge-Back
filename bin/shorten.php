<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Controllers\UrlShortener;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$filePath = __DIR__ . "/../storage/urls.json";

$logFile = __DIR__ . "/../storage/log.log";

$logger = new Logger('url-shortener');
$logger->pushHandler(new StreamHandler("$logFile"));

try {
	$short = new UrlShortener($filePath, $logger);
	$short->setLength(10);
	$codeShort = $short->encode("https://m6.com");
	$url = $short->decode("d7b6228dcf");
	echo PHP_EOL;
	echo $url;
	echo PHP_EOL;
} catch (InvalidArgumentException $e) {
	echo $e->getMessage();
}

