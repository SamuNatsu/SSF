<?php
namespace SSF;

class Option {
	static private $_opt = null;

	static public function init(): void {
		self::$_opt = \SSF\Database::getOptions();
		if (self::$_opt === false)
			throw new \Exception('\SSF\Option error, fail to get options');
	}

	static public function get(string $name, $fallback = null) {
		return array_key_exists($name, self::$_opt) ? self::$_opt[$name] : $fallback;
	}
	static public function set(string $name, string $data): void {
		self::$_opt[$name] = $data;

		if (!\SSF\Database::setOption($name, $data))
			throw new \Exception("\SSF\Option error, fail to set option $name");
	}

	static public function getHistory(): array {
		return \SSF\Database::getHistories();
	}
	static public function addHistory(string $msg): void {
		\SSF\Database::insertHistory(time(), \SSF\Session::getClientIP(), $msg);
	}
	static public function clearHistory(): void {
		\SSF\Database::clearHistories();
	}

	static public function title(string $tl): string {
		return preg_replace_callback_array([
			'/%title/' => function($match) use($tl) {
				return $tl;
			},
			'/%sitename/' => function($match) {
				return \SSF\Option::get('sitename');
			}
		], self::$_opt['title_format']);
	}
	static public function _title(string $tl): void {
		echo self::title($tl);
	}

	static public function gravatar(): string {
		if (self::$_opt['gravatar_url'] !== "")
			return self::$_opt['gravatar_url'];
		$url = self::$_opt['gravatar_service'] . '/avatar/';
		$url .= md5(strtolower(trim(self::$_opt['email'])));
		$url .= '?s=256';
		return $url;
	}
	static public function _gravatar(): void {
		echo self::gravatar();
	}

	static public function date(int $tm): string {
		return date(self::$_opt['time_format'], $tm);
	}
	static public function _date(int $tm): void {
		echo self::date($tm);
	}

};
