<?php
namespace SSF;

class Router {
	static private $rootUrl = '';
	static private $routeTable = [];
	static private $pathTable = [];

	static public function init(string $rootDir): void {
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
			self::$rootUrl = 'https://';
		else 
			self::$rootUrl = 'http://';

		self::$rootUrl .= $_SERVER['HTTP_HOST'];
		self::$rootUrl .= str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath($rootDir));
	}

	static public function root(string $suffix = '', bool $mode = false): string {
		if ($mode)
			echo self::$rootUrl . $suffix;
		return self::$rootUrl . $suffix;
	}

	static public function __callStatic(string $key, array $args): string {
		if (!isset(self::$pathTable[$key]))
			return '';
		if (count($args) == 0)
			return self::$pathTable[$key];
		if (count($args) > 1 && $args[1] === true)
			echo self::$pathTable[$key] . $args[0];
		return self::$pathTable[$key] . $args[0];
	}

	static public function addPage(string $name, string $path): void {
		self::$routeTable[$name] = $path;
	}

	static public function addPath(string $name, string $path): void {
		self::$pathTable[$name] = $path;
	}

	static public function getTable(): array {
		return self::$routeTable;
	}

	static public function GET(string $key) {
		return isset($_GET[$key]) ? $_GET[$key] : false;
	}

	static public function POST(string $key) {
		return isset($_POST[$key]) ? $_POST[$key] : false;
	}

	static public function despatch(): void {
		if (isset($_GET['action']))
			\SSF\Action::despatch();
		else if (isset($_GET['page']) && isset(self::$routeTable[$_GET['page']])) {
			require_once(self::$routeTable[$_GET['page']]);
			exit;
		}

		header('HTTP/1.1 404 Not Found');
		if (isset(self::$routeTable['404']))
			require_once(self::$routeTable['404']);
		exit;
	}

	static public function jump(string $url): void {
		header('Location: ' . $url);
		exit;
	}
};
