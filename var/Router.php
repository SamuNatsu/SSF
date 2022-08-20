<?php
namespace SSF;

class Router {
	static private $_table = [];

	static public function register(string $key, string $path, bool $overwrite = true): bool {
		if (isset(self::$_table[$key]) && !$overwrite)
			return false;

		if (!is_file($path))
			return false;

		self::$_table[$key] = $path;
		return true;
	}

	static public function unregister(string $key): void {
		if (isset(self::$_table[$key]))
			unset(self::$_table[$key]);
	}

	static public function getTable(): array {
		return self::$_table;
	}

	static public function GET(string $key, $fallback = false) {
		return isset($_GET[$key]) ? $_GET[$key] : $fallback;
	}

	static public function POST(string $key, $fallback = false) {
		return isset($_POST[$key]) ? $_POST[$key] : $fallback;
	}

	static public function jump(string $url): void {
		header('Location: ' . $url);
		exit;
	}

	static public function despatch(): void {
		if (!isset($_GET['page']))
			$_GET['page'] = '';

		if (isset($_GET['action']))
			\SSF\Action::despatch();
		else if (isset(self::$_table[$_GET['page']])) {
			require_once(self::$_table[$_GET['page']]);
			exit;
		}

		header('HTTP/1.1 404 Not Found');
		if (isset(self::$_table['404']))
			require_once(self::$_table['404']);
		exit;
	}

};
