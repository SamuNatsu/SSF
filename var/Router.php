<?php
namespace SSF;

// Check flag
if (!defined('__SSF__')) exit;

class Router {
	private $rootUrl = '';
	private $route = [];
	private $query = [];

	public function __construct(string $rootDir) {
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
			$this->rootUrl = 'https://';
		else 
			$this->rootUrl = 'http://';
		$this->rootUrl .= $_SERVER['HTTP_HOST'];
		$this->rootUrl .= str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath($rootDir));

		$tmp = explode('&', $_SERVER['QUERY_STRING']);
		foreach ($tmp as $i) {
			$kv = explode('=', $i);
			if (count($kv) == 2)
				$this->query[$kv[0]] = $kv[1];
		}
	}

	public function root(string $suffix = '', bool $mode = false) {
		if ($mode)
			echo $this->rootUrl . $suffix;
		return $this->rootUrl . $suffix;
	}

	public function set(string $name, string $path) {
		$this->route[$name] = $path;
	}

	public function get(string $name) {
		return isset($this->route[$name]) ? $this->route[$name] : null;
	}

	public function despatch() {
		if (!isset($this->query['page']) || !isset($this->route[$this->query['page']])) {
			if (isset($this->route['404']))
				require_once($this->route['404']);
			else
				header('HTTP/1.1 404 Not Found');
		}
		else
			require_once($this->route[$this->query['page']]);
	}
};
