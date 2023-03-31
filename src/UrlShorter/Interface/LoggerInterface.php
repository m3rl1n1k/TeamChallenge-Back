<?php

namespace Controllers;
interface LoggerInterface {
	public function log($level, string|\Stringable $message, array $context = []);
}