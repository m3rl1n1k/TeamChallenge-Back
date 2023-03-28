<?php

require_once __DIR__ . "/../vendor/autoload.php";
use Controllers\UrlShortener;

$filePath = __DIR__ . "/../storage/urls.json";

$short = new UrlShortener($filePath);
$short->setLength(10);

$codeShort = $short->encode("https://google.com/page-1");
$url = $short->decode("3a8ba2c470");
echo PHP_EOL;
echo $url;
echo PHP_EOL;
