<?php
namespace SSF;

// Plugin exception
class PluginException extends Exception {
	public function __construct(string $message) {
		parent::__construct(__CLASS__, $message);
	}
}

// Plugin interface
interface PluginInterface {
	static public function startUp(): void;
	static public function option(): void;
}

// Plugin
class Plugin {
	static private $_table = [
		'startUp' => [],
		'onHeader' => [],
		'onFooter' => [],
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

	// Register event
	static public function registerEvent(string $event): void {
		if (isset(self::$_table[$event]))
			throw new PluginException('Event has been registered');

		self::$_table[$event] = [];
	}
	// Unregister event
	static public function unregisterEvent(string $event): void {
		static $reserved = [
			'startUp', 
			'onHeader', 'onFooter', 
			'onEdit', 'onSave', 'onDelete', 
			'beforeGenerate', 'afterGenerate', 'beforeParse', 'afterParse'];
		
		if (in_array($event, $reserved))
			throw new PluginException('Not allowed to unregister reserved event');

		unset(self::$_table[$event]);
	}

	// Register trigger
	static public function registerTrigger(string $event, string $trigger, int $priority = 100): void {
		if (!isset(self::$_table[$event]))
			throw new PluginException('Event not exists');

		if (!method_exists($trigger))
			throw new PluginException('Trigger not exists');

		if ($priority <= 0)
			throw new PluginException('Priority must be greater than 0');

		self::$_table[$event][$trigger] = $priority;
	}
	// Unregister trigger
	static public function unregisterTrigger(string $event, string $trigger): void {
		unset(self::$_table[$event][$trigger]);
	}

	// Trigger
	static public function trigger(string $event, ?array $args = null): void {
		if (!isset(self::$_table[$event]))
			throw new PluginException('Event not exists');

		uasort(self::$_table[$event], function($a, $b) {
			return $a - $b;
		});

		foreach (self::$_table[$event] as $trigger => $priority)
			call_user_func($trigger, $args);
	}

	// Get priority table
	static public function getTable(): array {
		return self::$_table;
	}

}
