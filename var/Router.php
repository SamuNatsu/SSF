<?php
namespace SSF;

class Router {
	static private $_table = [];

	static public function addPage(string $key, string $path, bool $overwrite = true): bool {
		if (isset(self::$_table[$key]) && !$overwrite)
			return false;

		self::$_table[$key] = $path;
		return true;
	}

	static public function removePage(string $key): void {
		if (isset(self::$_table[$key]))
			unset(self::$_table[$key]);
	}

	static public function get_table(): array {
		return self::$_table;
	}

	static public function GET(string $key) {
		return isset($_GET[$key]) ? $_GET[$key] : false;
	}

	static public function POST(string $key) {
		return isset($_POST[$key]) ? $_POST[$key] : false;
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
