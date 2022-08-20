<?php
namespace SSF;

class Session {
	static private $_clientIP;

	static public function start(): void {
		session_start();

		if (!isset($_SESSION['login'])) {
			$_SESSION['login'] = false;
			$_SESSION['login_time'] = -1;
		}

		if (time() - $_SESSION['login_time'] > 86400)
			$_SESSION['login'] = false;

		if (isset($_SERVER['HTTP_CLIENT_IP']))
			self::$_clientIP = $_SERVER['HTTP_CLIENT_IP'];
		if (isset($_SERVER['HTTP_X_REAL_IP']))
			self::$_clientIP = $_SERVER['HTTP_X_REAL_IP'];
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			self::$_clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			self::$_clientIP = explode(',', self::$_clientIP);
			self::$_clientIP = self::$_clientIP[0];
		}
		else if (isset($_SERVER['REMOTE_ADDR']))
			self::$_clientIP = $_SERVER['REMOTE_ADDR'];
		else 
			self::$_clientIP = '0.0.0.0';
	}
	static public function stop(): void {
		session_unset();
		session_destroy();
	}

	static public function get(string $key, $fallback = null) {
		return isset($_SESSION[$key]) ? $_SESSION[$key] : $fallback;
	}
	static public function set(string $key, $val): void {
		$_SESSION[$key] = $val;
	}

	static public function getClientIP(): string {
		return self::$_clientIP;
	}

	static public function isLogin(): bool {
		return $_SESSION['login'];
	}
	static public function setLogin(): void {
		$_SESSION['login'] = true;
		$_SESSION['login_time'] = time();
	}
};
