<?php
namespace SSF;

// Action exception
class ActionException extends Exception {}

// Action interface
interface ActionInterface {
	static public function run(): void;
}

// Action
class Action {
	static private $_table = [];

	// Register an action
	static public function register(string $name, string $action, bool $overwrite = false): void {
		if (preg_match('/^\w+:\w+$/', $name) !== 1)
			throw new ActionException("Invalid action name \"$name\", which should be formatted as \"namespace:name\"");

		if (isset(self::$_table[$name]) && !$overwrite)
			throw new ActionException("Action name \"$name\" duplicated, but overwrite is not allowed");

		if (!isset(class_implements($action)['ActionInterface']))
			throw new ActionException("Action class \"$action\" should implement interface \\SSF\\ActionInterface");

		self::$_table[$name] = $action;
	}
	// Unregister an action
	static public function unregister(string $name): void {
		unset(self::$_table[$name]);
	}

	// Get action class
	static public function getClass(string $name): ?string {
		return self::$_table[$name] ?? null;
	}
	// Get action table
	static public function getTable(): array {
		return self::$_table;
	}

	// Execute
	static public function execute(string $name): void {
		if (!isset(self::$_table[$name]))
			throw new ActionException("Action \"$name\" not found");

		call_user_func(self::$_table[$name] . '::run');
	}

}
