<?php

namespace NewV\Interface;

interface LoggerInterface {
	public function log($level, string|\Stringable $message, array $context = []);
}