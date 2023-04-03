<?php

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use NewV\Divider;
use NewV\Files;
use NewV\UrlShort;

require_once __DIR__ . "/../vendor/autoload.php";


$files = new Files();
$files->setPathUrls(__DIR__ . "/../storage/urlNew.json");
$files->setPathLogs(__DIR__ . "/../storage/newLogger.log");

$logger = new Logger('new_url_shorter');
$logger->pushHandler(new StreamHandler($files->getPathLogs(), Level::Info));

try {
	$short = new UrlShort($files, $logger);
	$short->setLength(10);
	$short->setLink("https://google.com/search/moah")->individual()->encode();
	$short->setCode("5957c7bc5f")->decode();
	$short->showUrls();
} catch (InvalidArgumentException $exception) {
	new Divider('=', 19);
	Divider::printString($exception->getMessage());
}