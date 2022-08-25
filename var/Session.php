<?php
namespace SSF;

// Session
class Session {
	static private $_clientIP;

	// Start session
	static public function start(): void {
		// Get client IP
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

		// Start session
		session_start();

		// Check first time
		if (!isset($_SESSION['login'])) {
			$_SESSION['login_status'] = false;
			$_SESSION['login_time'] = -1;
			$_SESSION['data'] = [];
		}
		// Check timeout
		else if (time() - $_SESSION['login_time'] > 86400) {
			$_SESSION['login_status'] = false;
			\SSF\Option::addHistory('[Info] Logout: Timeout');
		}
	}
	// Stop session
	static public function stop(): void {
		session_unset();
		session_destroy();
	}

	// Wrapped get
	static public function get(string $key, $fallback = null) {
		return $_SESSION['data'][$key] ?? $fallback;
	}
	// Wrapped set
	static public function set(string $key, $val): void {
		$_SESSION['data'][$key] = $val;
	}

	// Get client IP
	static public function getClientIP(): string {
		return self::$_clientIP;
	}

	// Check login
	static public function isLogin(): bool {
		return $_SESSION['login_status'];
	}
	// Set login status
	static public function setLogin(): void {
		$_SESSION['login'] = true;
		$_SESSION['login_time'] = time();
	}
}
