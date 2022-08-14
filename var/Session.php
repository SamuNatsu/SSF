<?php
namespace SSF;

class Session {
	static private $clientIP;

	static public function start(): void {
		session_start();

		if (!isset($_SESSION['login'])) {
			$_SESSION['login'] = false;
			$_SESSION['login_time'] = -1;
		}

		if (time() - $_SESSION['login_time'] > 86400)
			$_SESSION['login'] = false;

		if (isset($_SERVER['HTTP_CLIENT_IP']))
			self::$clientIP = $_SERVER['HTTP_CLIENT_IP'];
		if (isset($_SERVER['HTTP_X_REAL_IP']))
			self::$clientIP = $_SERVER['HTTP_X_REAL_IP'];
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			self::$clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			self::$clientIP = explode(',', self::$clientIP);
			self::$clientIP = self::$clientIP[0];
		}
		else if (isset($_SERVER['REMOTE_ADDR']))
			self::$clientIP = $_SERVER['REMOTE_ADDR'];
		else 
			self::$clientIP = '0.0.0.0';
	}

	static public function stop(): void {
		session_unset();
		session_destroy();
	}

	static public function get(string $key) {
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	static public function set(string $key, $val): void {
		$_SESSION[$key] = $val;
	}

	static public function getClientIP(): string {
		return self::$clientIP;
	}
};
