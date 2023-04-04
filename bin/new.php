<?php

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use NewV\Decode;
use NewV\Divider;
use NewV\Encode;
use NewV\Files;
use NewV\UrlShort;
use NewV\Validator;

require_once __DIR__ . "/../vendor/autoload.php";
$config = require_once __DIR__ . "/../config/config.php";

$logger = new Logger('new_url_shorter');
$logger->pushHandler(new StreamHandler($config['pathToLogs'], Level::Info));

$validator = new Validator();
$file = new Files($config['pathToUrls']);
$short = new UrlShort($file, $logger, $validator);
$encode = new Encode();
$decode = new Decode($short->getUrls());
try {
	$short->setLength(10);
	$short->setLink("https://google.com/search")->individual()->encode($encode);
	$short->setCode("5957c7bc5f")->decode($decode);
	$short->showUrls();
} catch (InvalidArgumentException $exception) {
	new Divider('=', 19);
	Divider::printString($exception->getMessage());
}