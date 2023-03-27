<?php


use Controllers\UrlShortener;

$filePath = "../storage/urls.json";

$shortCode = new UrlShortener($filePath);
$shortCode->setLength(10);

$codeShort = $shortCode->encode("https://free-url-shortener.rb.gy/3424234");
$code = "3a7e0e33b0";
$url = $shortCode->decode($code);
echo PHP_EOL;
echo $codeShort;
echo PHP_EOL;
