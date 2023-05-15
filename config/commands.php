<?php

use Bisix21\src\Commands\DecodeCommand;
use Bisix21\src\Commands\DefaultCommands;
use Bisix21\src\Commands\EncodeCommand;

return [
	'allowed:encode' => EncodeCommand::class,
	'allowed:decode' => DecodeCommand::class,
	'allowed:help' => DefaultCommands::class,
];