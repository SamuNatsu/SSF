<?php
namespace SSF;

// Check flag
if (!defined('__SSF__')) exit;

class Options {
	static private $db_id;
	static private $opt;

	static public function init() {
		$result = $GLOBALS['DB']->findBy(['db', '=', 'options']);
		self::$opt = $result[0];
		self::$db_id = self::$opt['_id'];
		unset(self::$opt['_id']);
	}
	static public function update() {
		$GLOBALS['DB']->updateById(self::$db_id, self::$opt);
	}

	static public function get(string $key) {
		return isset(self::$opt[$key]) ? self::$opt[$key] : null;
	}
	static public function set(string $key, mixed $val) {
		self::$opt[$key] = $val;
	}

	static private $titleString;
	static private function titleFormat(string $str) {
		if (!isset(self::$opt['title-pattern']) || !isset(self::$opt['sitename']))
			return '';
		self::$titleString = $str;
		$str = preg_replace_callback_array([
			'/%title/' => function($match) {
				return Options::$titleString;
			},
			'/%sitename/' => function($match) {
				return self::$opt['sitename'];
			}
		],
		self::$opt['title-pattern']);
		return $str;
	}
	static public function title(string $str, bool $mode = false) {
		$str = self::titleFormat($str);
		if ($mode)
			echo $str;
		return $str;
	}
};
