<?php
namespace SSF;

// Plugin Exception
class Plugin extends Exception {}

// Plugin interface
interface PluginInterface {
	static public function startUp(): void;
	static public function option(): void;
}

// Plugin
class Plugin {
	static private $_priority = [
		'startUp' => [],
		'onHeader' => [],
		'onHooter' => [],
		'onEdit' => [],
		'onSave' => [],
		'onDelete' => [],
		'beforeGenerate' => [],
		'afterGenerate' => [],
		'beforeParse' => [],
		'afterParse' => []
	];

	// Initialize
	static public function init(): void {}

	// Register a plugin
	static public function register(string $plugin, int $priority = 100): void {
		if (!isset(class_implements($plugin)['PluginInterface']))
			throw new PluginException("Plugin class \"$plugin\" should implement interface \\SSF\\PluginInterface");
		
		if (isset(self::$_table[$plugin]))
			throw new PluginException("Plugin \"$plugin\" has been already registered");

		self::$_priority['startUp'][$plugin . '::startUp'] = $priority;
		uasort(self::$_priority['startUp'], function($a, $b) {
			return $a - $b;
		});
	}
	// Unregister a plugin
	static public function unregister(string $plugin): void {
		foreach (self::$_priority as $event => &$list)
			unset($list[$plugin]);
	}

	// Trigger event
	static public function __callStatic(string $event): void {
		if (!isset(self::$_priority[$event]))
			throw new PluginException("Event \"$event\" not defined");

		foreach (self::$_priority[$event] as $plugin => $priority)
			call_user_func($plugin);
	}

	// Get priority table
	static public function getPriorityTable(): array {
		return self::$_priority;
	}

}
