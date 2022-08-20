<?php
namespace SSF;

class Options {
	static public function getPassword(): string {
		$tmp = \SSF\DB::at('options')->findById(1);
		return $tmp['password'];
	}
	static public function setPassword(string $pass): string {
		$tmp = \SSF\DB::at('options')->findById(1);
		$tmp['password'] = $pass;
		unset($tmp['_id']);
		\SSF\DB::at('options')->updateById(1, $tmp);
	}

	static public function getLoginHistory(): array {
		$tmp = \SSF\DB::at('options')->findById(2);
		return $tmp['login_history'];
	}
	static public function addLoginHistory(string $status): void {
		$tmp = \SSF\DB::at('options')->findById(2);
		if ($tmp['max_login_history'] === 0)
			return;
		array_push($tmp['login_history'], [
			'time' => time(),
			'ip' => \SSF\Session::getClientIP(),
			'status' => $status
		]);
		if (count($tmp) >= $tmp['max_login_history'])
			array_shift($tmp['login_history']);
		unset($tmp['_id']);
		\SSF\DB::at('options')->updateById(2, $tmp);
	}

	static public function getMaxLoginHistory(): int {
		$tmp = \SSF\DB::at('options')->findById(2);
		return $tmp['max_login_history'];
	}
	static public function setMaxLoginHistory(int $mx): void {
		$tmp = \SSF\DB::at('options')->findById(2);
		$tmp['max_login_history'] = $mx;
		unset($tmp['_id']);
		\SSF\DB::at('options')->updateById(2, $tmp);
	}

	static public function title(string $tl): string {
		$tmp = \SSF\DB::at('options')->findById(1);
		return preg_replace_callback_array([
			'/%title/' => function($match) use($tl) {
				return $tl;
			},
			'/%sitename/' => function($match) use($tmp) {
				return $tmp['sitename'];
			}
		], $tmp['title_pattern']);
	}
	static public function _title(string $tl): void {
		echo self::title($tl);
	}

	static public function gravatar(): string {
		$tmp = \SSF\DB::at('options')->findById(1);
		if ($tmp['gravatar_url'] !== "")
			return $tmp['gravatar_url'];
		$url = $tmp['gravatar_service'] . '/avatar/';
		$url .= md5(strtolower(trim($tmp['email'])));
		$url .= '?s=256';
		return $url;
	}
	static public function _gravatar(): void {
		echo self::gravatar();
	}

	static public function get(string $key, $default = false) {
		$tmp = \SSF\DB::at('options')->findById(1);
		return isset($tmp[$key]) ? $tmp[$key] : $default;
	}
	static public function set(string $key, $val) {
		$tmp = \SSF\DB::at('options')->findById(1);
		$tmp[$key] = $val;
		unset($tmp['_id']);
		\SSF\DB::at('options')->updateById(1, $tmp);
	}

};
