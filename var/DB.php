<?php
namespace SSF;

class DB {
	static private $_table = [];

	static public function init(): void {
		$ls = scandir(__SSF_DB__);
		foreach ($ls as $dbname)
			if ($dbname != '.' && $dbname != '..')
				self::$_table[$dbname] = new \SleekDB\store($dbname, __SSF_DB__, ['timeout' => false]);
	}

	static public function &at(string $key): \SleekDb\store {
		if (!isset(self::$_table[$key]))
			self::$_table[$key] = new \SleekDB\store($key, __SSF_DB__, ['timeout' => false]);

		return self::$_table[$key];
	}

	static public function getTable(): array {
		return array_keys(self::$_table);
	}

};
