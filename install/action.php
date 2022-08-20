<?php

namespace SSF\Action;

class Install implements \SSF\ActionInterface {
	static private function checkPOST(): void {
		if (\SSF\Router::POST('password') === false) {
			echo '{"status":"fail","msg":"Invalid POST"}';
			exit;
		}
	}

	static private function validate(string $pass): void {
		if (strlen($pass) < 8) {
			echo '{"status":"fail","msg":"Password length TOO short"}';
			exit;
		}
		if (!preg_match('/[A-Z]/', $pass)) {
			echo '{"status":"fail","msg":"Password MUST contains upper case letter"}';
			exit;
		}
		if (!preg_match('/[a-z]/', $pass)) {
			echo '{"status":"fail","msg":"Password MUST contains lower case letter"}';
			exit;
		}
		if (!preg_match('/\d/', $pass)) {
			echo '{"status":"fail","msg":"Password MUST contains digit"}';
			exit;
		}
		if (!preg_match('/^[A-Za-z\d@$!%*#?&-]{8,}$/', $pass)) {
			echo '{"status":"fail","msg":"Password contains INVALID character"}';
			exit;
		}
	}

	static private function genRndStr(): string {
		$charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_+';
		$str = '';
		for ($i = 0; $i < 20; ++$i)
			$str .= $charset[rand(0, 63)];
		return $str;
	}

	static public function run(): void {
		self::checkPOST();
		$pass = \SSF\Router::POST('password');

		self::validate($pass);
		$pass = md5(sha1($pass));

		$dbname = self::genRndStr();
		$dbdir = \SSF\Path::dir('www', "/$dbname");
		file_put_contents(\SSF\Path::dir('www', '/config.php'), "<?php\ndefine('__SSF__', '');\ndefine('__SSF_DB__', '$dbdir');\n");

		// Initialize db
		require_once(\SSF\Path::dir('var', '/SleekDB/SleekDB.php'));
		$db = new \SleekDB\store('options', $dbdir, ['timeout' => false]);
		$db->insert([
			'password' => $pass,
			'sitename' => 'Test site',
			'description' => 'Test description',
			'title_pattern' => '%title - %sitename',
			'email' => 'test@test.test',
			'gravatar_service' => 'https://gravatar.loli.net',
			'gravatar_url' => '',
			'time_format' => 'Y/m/d H:i:s'
		]);
		$db->insert([
			'max_login_history' => 30,
			'login_history' => []
		]);
		$db->insert(['active_plugin' => []]);
		$db->insert(['posts_meta' => []]);
		$db->insert(['category' => []]);
		$db->insert(['tag' => []]);
		$db->insert(['link' => []]);

		$db = new \SleekDB\store('posts', $dbdir, ['timeout' => false]);

		echo '{"status":"success","href":"' . \SSF\Path::url('admin', '/') . '"}';
	}
};
