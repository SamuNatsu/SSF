<?php
namespace SSF;

interface ActionInterface {
	static public function run(): void;
}

class Action {
	static private $_table = [];

	static public function register(string $name, string $action, bool $overwrite = true): bool {
		if (preg_match('/^\w+:\w+$/', $name) !== 1)
			return false;

		if (isset(self::$_table[$name]) && !$overwrite)
			return false;

		self::$_table[$name] = $action;
		return true;
	}

	static public function unregister(string $name): void {
		if (isset(self::$_table[$name]))
			unset(self::$_table[$name]);
	}

	static public function getTable(): array {
		return self::$_table;
	}

	static public function despatch(): void {
		$tmp = \SSF\Router::GET('action');

		if (!isset(self::$_table[$tmp])) {
			header('HTTP/1.1 404 Not Found');
			exit;
		}

		$tmp = self::$_table[$tmp];
		if (!method_exists($tmp, 'run')) {
			header('HTTP/1.1 501 Not Implemented');
			exit;
		}

		call_user_func($tmp . '::run');
		exit;
	}
};
