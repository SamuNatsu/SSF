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

		\SSF\Database::init($dbdir);
		\SSF\Database::create($pass);
		file_put_contents(\SSF\Path::dir('www', '/config.php'), "<?php\ndefine('__SSF__', '');\ndefine('__SSF_DB__', '$dbdir');\n");

		echo '{"status":"success","href":"' . \SSF\Path::url('admin', '/') . '"}';
	}
};
