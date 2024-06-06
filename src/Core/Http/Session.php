<?php

namespace App\Core\Http;


class Session
{
	public static function add(array $data): void
	{
		foreach ($data as $key => $value) {
			$_SESSION[$key] = $value;
		}
	}

	public static function get(string $key)
	{
		return $_SESSION[$key];
	}

	public static function remove(string|array $key): void
	{
		if (is_array($key)) {
			foreach ($key as $item) {
				unset($_SESSION[$item]);
			}
		}
		if (is_string($key)) {
			unset($_SESSION[$key]);
		}
	}

	public static function sessionStart(): void
	{
		if (empty(session_id())) {
			session_start();
		}
	}

	public static function stop(): void
	{
		session_abort();
		session_destroy();
	}
}