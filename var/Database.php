<?php
namespace SSF;

class Database {
	// SQLite3 object
	static private $_db = null;

	// Initialize
	static public function init(string $path) {
		self::$_db = new \SQLite3($path);
	}

	// Insert an option
	static public function insertOption(string $name, string $data): bool {
		return @self::$_db->exec("INSERT INTO option(name, data) VALUES('$name', '$data')");
	}
	// Update an option
	static public function updateOption(string $name, string $data): bool {
		return @self::$_db->exec("UPDATE option SET data='$data' WHERE name='$name'");
	}
	// Set an option
	static public function setOption(string $name, string $data): bool {
		return self::updateOption($name, $data) ? true : self::insertOption($name, $data);
	}
	// Delete an option
	static public function deleteOption(string $name): bool {
		return @self::$_db->exec("DELETE FROM option WHERE name='$name'");
	}
	// Get an option by name
	static public function getOption(string $name) {
		$result = @self::$_db->query("SELECT data FROM option WHERE name='$name'");
		return $result === false ? null : $result->fetchArray(SQLITE3_NUM)[0];
	}
	// Get option table
	static public function getOptions() {
		$result = @self::$_db->query('SELECT name, data FROM option');
		if ($result === false)
			return null;

		$arr = [];
		while ($item = $result->fetchArray(SQLITE3_ASSOC))
			$arr[$item['name']] = $item['data'];

		return $arr;
	}

	// Insert a history
	static public function insertHistory(int $time, string $ip, string $msg): bool {
		$limit = self::getOption('max_history');
		if ($limit === false)
			return false;

		$limit = intval($limit);
		$btm = @self::$_db->query('SELECT id FROM history ORDER BY id ASC LIMIT 1');
		$top = @self::$_db->query('SELECT id FROM history ORDER BY id DESC LIMIT 1');
		if ($btm === false || $top === false)
			return false;

		$tmp = $btm->fetchArray(SQLITE3_NUM);
		$btm = ($tmp === false ? 0 : $tmp[0]);
		$tmp = $top->fetchArray(SQLITE3_NUM);
		$top = ($tmp === false ? -1 : $tmp[0]);

		while ($top - $btm + 1 >= $limit) {
			@self::$_db->exec("DELETE FROM history WHERE id=$btm");
			++$btm;
		}

		return @self::$_db->exec("INSERT INTO history(time, ip, msg) VALUES($time, '$ip', '$msg')");
	}
	// Clear history table
	static public function clearHistories(): bool {
		return @self::$_db->exec('DELETE FROM history');
	}
	// Get history table
	static public function getHistories() {
		$result = @self::$_db->query('SELECT time, ip, msg FROM history ORDER BY id DESC');
		if ($result === false)
			return null;

		$arr = [];
		while ($item = $result->fetchArray(SQLITE3_ASSOC))
			array_push($arr, $item);

		return $arr;
	}

	// Insert a meta
	static public function insertMeta(int $type, string $name, string $data) {
		if (!@self::$_db->exec("INSERT INTO meta(type, name, data) VALUES($type, '$name', '$data')"))
			return false;

		$result = @self::$_db->query("SELECT id FROM meta ORDER BY id DESC LIMIT 1");
		if ($result === false)
			return false;
		
		$result = $result->fetchArray(SQLITE3_NUM);
		if ($result === false)
			return false;

		return $result[0];
	}
	// Update a meta
	static public function updateMeta(int $id, string $name, string $data): bool {
		return @self::$_db->exec("UPDATE meta SET name='$name',data='$data' WHERE id=$id");
	}
	// Delete a meta
	static public function deleteMeta(int $id): bool {
		return @self::$_db->exec("DELETE FROM meta WHERE id=$id");
	}
	// Get meta table
	static public function getMetas() {
		$result = @self::$_db->query('SELECT * FROM meta');
		if ($result === false)
			return null;

		$arr = [];
		while ($item = $result->fetchArray(SQLITE3_ASSOC))
			array_push($arr, $item);

		return $arr;
	}

	// Insert a content
	static public function insertContent(string $data) {
		if (!@self::$_db->exec("INSERT INTO content(data) VALUES('$data')"))
			return false;

		$result = @self::$_db->query("SELECT id FROM content ORDER BY id DESC LIMIT 1");
		if ($result === false)
			return false;

		$result = $result->fetchArray(SQLITE3_NUM);
		if ($result === false)
			return false;

		return $result[0];
	}
	// Update a content
	static public function updateContent(int $id, string $data): bool {
		return @self::$_db->exec("UPDATE content SET data='$data' WHERE id=$id");
	}
	// Delete a content
	static public function deleteContent(int $id): bool {
		return @self::$_db->exec("DELETE FROM content WHERE id=$id");
	}

	// Create new database
	static public function create(string $pass) {
		// Create option
		@self::$_db->exec('DROP TABLE option');
		self::$_db->exec('CREATE TABLE option(name TEXT PRIMARY KEY NOT NULL, data TEXT NOT NULL)');
		self::insertOption('password', $pass);
		self::insertOption('sitename', 'Test site');
		self::insertOption('description', 'Test description');
		self::insertOption('keyword', 'ssf,test');
		self::insertOption('email', 'test@test.com');
		self::insertOption('gravatar_service', 'https://gravatar.loli.net');
		self::insertOption('gravatar_url', '');
		self::insertOption('time_format', 'Y/m/d H:i:s');
		self::insertOption('max_history', '30');
		self::insertOption('title_format', '%title - %sitename');

		// Create history
		@self::$_db->exec('DROP TABLE history');
		self::$_db->exec('CREATE TABLE history(id INTEGER PRIMARY KEY AUTOINCREMENT, time INTEGER NOT NULL, ip TEXT NOT NULL, msg TEXT NOT NULL)');

		// Create meta
		@self::$_db->exec('DROP TABLE meta');
		self::$_db->exec('CREATE TABLE meta(id INTEGER PRIMARY KEY AUTOINCREMENT, type INTEGER NOT NULL, name TEXT NOT NULL, data TEXT NOT NULL)');
		$time = time();
		self::insertMeta(__SSF_META_POST__, 'Test post', "{\"create_time\":$time,\"modify_time\":$time,\"category\":2,\"tags\":[3],\"cid\":1}");
		self::insertMeta(__SSF_META_CATEGORY__, 'Test category', 'Test');
		self::insertMeta(__SSF_META_TAG__, 'Test tag', 'Test');
		self::insertMeta(__SSF_META_LINK__, 'Test link', '{"description":"Test link description","url":"test.com","gravatar":null}');

		// Create content
		@self::$_db->exec('DROP TABLE content');
		self::$_db->exec('CREATE TABLE content(id INTEGER PRIMARY KEY AUTOINCREMENT, data TEXT NOT NULL)');
		self::insertContent('{"content":"Test post","field":[],"password":null}');
	}
};
