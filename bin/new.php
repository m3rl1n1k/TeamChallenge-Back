<?php

use Config\Config;
use NewV\Divider;
use NewV\UrlShort;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

require_once __DIR__ . "/../vendor/autoload.php";


$logger = new Logger('new_url_shorter');
$logger->pushHandler(new StreamHandler(Config::PATH_LOG_DIR,  Level::Info));

try {
	$short = new UrlShort(Config::PATH_URL_DIR, $logger);
	$short->setLink("https://google.com")->encode();
	$short->setCode("6953b7ae23")->decode();
	$short->showUrls();
} catch (InvalidArgumentException $exception) {
	new Divider('=', 19);
	Divider::printString($exception->getMessage());
}