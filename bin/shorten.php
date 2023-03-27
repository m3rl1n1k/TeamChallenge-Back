<?php


use Controllers\UrlShortener;
//Налаштувати автолоадер композера таким чином, щоб він підключав файли вашого проєкту
//Допрацювати ваші обʼєкти тиким чином, щоб в них можна було прокинути логер монологу
// (залежність вказувати на абстракцію, а не на реалізацію)
//Організувати логування помилок і інформаційних сповіщень (можна щось ще),
// важливо використовувати різні рівні логування (можна навіть в різні файли)
//Додатковий бал за підключення якоїсь іншої додаткової залежності і використання її в своєму коді
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler("../storage/log.log", Level::Warning));

// add records to the log
$log->warning('Foo');
$log->error('Bar');

$filePath = "../storage/urls.json";

$shortCode = new UrlShortener($filePath);
$shortCode->setLength(10);

$codeShort = $shortCode->encode("https://free-url-shortener.rb.gy/3424234");
$code = "3a7e0e33b0";
$url = $shortCode->decode($code);
echo PHP_EOL;
echo $codeShort;
echo PHP_EOL;
