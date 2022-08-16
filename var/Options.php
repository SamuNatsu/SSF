<?php
namespace SSF;

class Options {
	static private $_option;

	static public function init() {
		self::$_option = $GLOBALS['DB']->findById(1);
		unset(self::$_option['_id']);
	}
	static public function update() {
		$GLOBALS['DB']->updateById(1, self::$_option);
	}

	static public function get(string $key) {
		return isset(self::$_option[$key]) ? self::$_option[$key] : false;
	}
	static public function set(string $key, $val) {
		self::$_option[$key] = $val;
	}

	static private $titleString;
	static private function titleFormat(string $str) {
		if (!isset(self::$_option['title-pattern']) || !isset(self::$_option['sitename']))
			return '';
		self::$titleString = $str;
		$str = preg_replace_callback_array([
			'/%title/' => function($match) {
				return Options::$titleString;
			},
			'/%sitename/' => function($match) {
				return self::$_option['sitename'];
			}
		],
		self::$_option['title-pattern']);
		return $str;
	}
	static public function title(string $str, bool $mode = false) {
		$str = self::titleFormat($str);
		if ($mode)
			echo $str;
		return $str;
	}

	static public function gravatar(): string {
		return self::$_option['gravatar-service'] . '/avatar/' . md5(strtolower(self::$_option['email'])) . '?s=256';
	}
};
