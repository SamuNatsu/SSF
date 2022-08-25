<?php
namespace SSF;

// Path exception
class PathException extends Exception {}

// Path
class Path {
	static private $_urlTable = [];
	static private $_dirTable = [];

	// Register a path
	static public function register(string $name, string $dir, bool $overwrite = false): void {
		$dir = realpath($dir);
		if ($dir === false)
			throw new PathException("Cannot get absolute path of \"$dir\"");
		self::$_dirTable[$name] = $dir;

		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://');
		$url .= $_SERVER['HTTP_HOST'];
		if (($_SERVER['SERVER_PORT'] == '80' && $url[4] != ':') ||
			($_SERVER['SERVER_PORT'] == '443' && $url[4] != 's') ||
			($_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443'))
			$url .= ':' . $_SERVER['SERVER_PORT'];
		$url .= str_replace($_SERVER['DOCUMENT_ROOT'], '', $dir);

		self::$_urlTable[$name] = $url;
	}
	// Unregister a path
	static public function unregister(string $name): void {
		unset(self::$_urlTable[$name]);
		unset(self::$_dirTable[$name]);
	}

	// Get url
	static public function url(string $name, string $suffix = ''): string {
		return (self::$_urlTable[$key] ?? '') . $suffix;
	}
	// Echo url
	static public function _url(string $name, string $suffix = ''): void {
		echo self::url($key, $suffix);
	}

	// Get directory
	static public function dir(string $name, string $suffix = ''): string {
		return (self::$_dirTable[$name] ?? '') . $suffix;
	}
	// Echo directory
	static public function _dir(string $name, string $suffix = ''): void {
		echo self::dir($name, $suffix);
	}

	// Get url table
	static public function getUrlTable(): array {
		return self::$_urlTable;
	}
	// Get dir table
	static public function getDirTable(): array {
		return self::$_dirTable;
	}

}
