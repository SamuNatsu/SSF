<?php

namespace SSF\Action;

class Install implements \SSF\ActionInterface {
	static public function run(): void {
		// Validate password
		if (\SSF\Router::POST('password') === false) {
			echo '{"status":"fail","msg":"Invalid POST"}';
			return;
		}
		$pass = \SSF\Router::POST('password');

		if (strlen($pass) < 6) {
			echo '{"status":"fail","msg":"Password length TOO short"}';
			return;
		}
		if (!preg_match('/\d/', $pass)) {
			echo '{"status":"fail","msg":"Password MUST contains digit"}';
			return;
		}
		if (!preg_match('/[a-zA-Z]/', $pass)) {
			echo '{"status":"fail","msg":"Password MUST contains letter"}';
			return;
		}
		$pass = md5(sha1($pass));

		// Generate config
		$charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_+';
		$dbname = '';
		for ($i = 0; $i < 20; ++$i)
			$dbname .= $charset[rand(0, 63)];
		file_put_contents(\SSF\Path::dir('www', '/config.php'), "<?php\ndefine('__SSF__', '');\ndefine('__SSF_DB__', '$dbname');\n");

		// Initialize db
		require_once(\SSF\Path::dir('var', '/SleekDB/SleekDB.php'));
		$db = new \SleekDB\store($dbname, \SSF\Path::dir('www'), ['timeout' => false]);
		$db->insert([
			'password' => $pass,
			'sitename' => 'Test site',
			'description' => 'Test description',
			'title-pattern' => '%title - %sitename',
			'email' => 'test@test.test',
			'gravatar-service' => 'https://gravatar.loli.net',
			'login-history' => [],
			'activated-plugin' => [],
		]);
		$db->insert([
			'page' => [],
			'category' => [],
			'tag' => [],
			'link' => [],
			'views' => '0'
		]);

		// Success
		echo '{"status":"success","href":"' . \SSF\Path::url('admin', '/') . '"}';
	}
};
