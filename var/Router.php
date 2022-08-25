<?php
namespace SSF;

// Router exception
class RouterException extends Exception {}

// Router
class Router {
	static private $_table = [];

	// Register a page
	static public function register(string $name, string $path, bool $overwrite = false): void {
		if (isset(self::$_table[$name]) && !$overwrite)
			throw new RouterException("Router name \"$name\" duplicated, but overwrite is not allowed");

		if (!is_file($path))
			throw new RouterException("Router path \"$path\" not exists");

		self::$_table[$key] = $path;
	}
	// Unregister a page
	static public function unregister(string $name): void {
		unset(self::$_table[$name]);
	}

	// Get page path
	static public function getPath(string $name): ?string {
		return self::$_table[$name] ?? null;
	}
	// Get routing table
	static public function getTable(): array {
		return self::$_table;
	}

	// Wrapped GET request
	static public function GET(string $key): ?string {
		return $_GET[$key] ?? null;
	}
	// Wrapped POST request
	static public function POST(string $key): ?string {
		return $_POST[$key] ?? null;
	}

	// Redirection
	static public function redirect(string $url, bool $permanent = false): void {
		header('Location: ' . $url, true, $permanent ? 301 : 302);
		exit;
	}

	// Despatch
	static public function despatch(): void {
		$action = self::GET('action');
		$page = self::GET('page');
		if ($action !== null && $page !== null)
			throw new RouterException("Ambiguous request, \"action\" and \"page\" cannot GET in the same time");

		if ($action !== null) {
			\SSF\Action::execute($name);
			exit;
		}

		if ($page === null)
			$page = '';

		if (isset(self::$_table[$page])) {
			require_once(self::$_table[$page]);
			exit;
		}

		header('HTTP/1.1 404 Not Found');
		if (isset(self::$_table['404']))
			require_once(self::$_table['404']);
		exit;
	}

}
