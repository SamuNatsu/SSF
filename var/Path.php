<?php
namespace SSF;

class Path {
	static private $_urlTable = [];
	static private $_dirTable = [];

	static public function setDir(string $key, string $dir): void {
		self::$_dirTable[$key] = realpath($dir);

		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://');
		$url .= $_SERVER['HTTP_HOST'];
		if (($_SERVER['SERVER_PORT'] == '80' && $url[4] != ':') ||
			($_SERVER['SERVER_PORT'] == '443' && $url[4] != 's') ||
			($_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443'))
			$url .= ':' . $_SERVER['SERVER_PORT'];
		$url .= str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath($dir));

		self::$_urlTable[$key] = $url;
	}
	static public function setRootDir(string $dir): void {
		self::setDir('root', $dir);
	}

	static public function removeDir(string $key): void {
		if (isset(self::$_urlTable[$key])) {
			unset(self::$_urlTable[$key]);
			unset(self::$_dirTable[$key]);
		}
	}

	static public function url(string $key, string $suffix = '', $fallback = false) {
		return isset(self::$_urlTable[$key]) ? self::$_urlTable[$key] . $suffix : $fallback;
	}
	static public function _url(string $key, string $suffix = '', string $fallback = ''): void {
		echo self::url($key, $suffix, $fallback);
	}

	static public function dir(string $key, string $suffix = '', $fallback = false): string {
		return isset(self::$_dirTable[$key]) ? self::$_dirTable[$key] . $suffix : $fallback;
	}
	static public function _dir(string $key, string $suffix = '', string $fallback = ''): void {
		echo self::dir($key, $suffix, $fallback);
	}

	static public function getDirTable(): array {
		return self::$_dirTable;
	}
	
	static public function getUrlTable(): array {
		return self::$_urlTable;
	}

};
