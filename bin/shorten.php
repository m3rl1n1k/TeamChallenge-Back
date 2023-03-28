<?php

use Controllers\UrlShortener;

$filePath = __DIR__ . "/../storage/urls.json";

$short = new UrlShortener($filePath);
$short->setLength(10);

$codeShort = $short->encode("https://free-url-shortener.rb.gy/1111");
$url = $short->decode("3a7e0e33b0");
echo PHP_EOL;
echo $short->encode("https://free-url-shortener.rb.gy/1111");
echo PHP_EOL;
echo $url;
echo PHP_EOL;
