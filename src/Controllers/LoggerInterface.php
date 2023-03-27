<?php

namespace App\Controllers;

interface LoggerInterface {
	public function log($level, $message);
}