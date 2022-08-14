<?php
namespace SSF;

interface ActionInterface {
	static public function run(): void;
}

class Action {
	static private $table = [];

	static public function register(string $namespace, string $name, string $action): bool {
		if (preg_match('/^\w+$/', $namespace) !== 1 || preg_match('/^\w+$/', $name) !== 1)
			return false;

		if (!isset(self::$table[$namespace]))
			self::$table[$namespace] = [];

		self::$table[$namespace][$name] = $action;
		return true;
	}

	static public function unregister(string $namespace, string $name): void {
		if (!isset(self::$table[$namespace]) || !isset(self::$table[$namespace][$name]))
			return;

		unset(self::$table[$namespace][$name]);
	}

	static public function getTable(): array {
		return table;
	}

	static public function despatch(): void {
		$tmp = \SSF\Router::GET('action');
		$tmp = explode(':', $tmp);

		if (count($tmp) != 2 || !isset(self::$table[$tmp[0]]) || !isset(self::$table[$tmp[0]][$tmp[1]])) {
			header('HTTP/1.1 404 Not Found');
			exit;
		}

		$tmp = self::$table[$tmp[0]][$tmp[1]];
		if (!method_exists($tmp, 'run')) {
			header('HTTP/1.1 404 Not Found');
			exit;
		}

		call_user_func($tmp . '::run');
		exit;
	}
};
