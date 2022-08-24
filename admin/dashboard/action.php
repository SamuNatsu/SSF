<?php
namespace SSF\Action;

class Logout implements \SSF\ActionInterface {
	static public function run(): void {
		if (!\SSF\Session::isLogin()) {
			\SSF\Option::addHistory('[Fail] Logout: No login');
			exit;
		}

		\SSF\Session::stop();
		\SSF\Option::addHistory('[Success] Logout: Manual');
	}
};
\SSF\Action::register('ssf:logout', '\SSF\Action\Logout');

class ModifyEmail implements \SSF\ActionInterface {
	static private function checkPOST(): void {
		if (\SSF\Router::POST('data') === false) {
			echo '{"status":"fail","msg":"Invalid POST"}';
			\SSF\Option::addHistory('[Fail] Modify email: Invalid POST');
			exit;
		}
	}

	static public function run(): void {
		if (!\SSF\Session::isLogin()) {
			echo '{"status":"fail","msg":"Please login"}';
			\SSF\Option::addHistory('[Fail] Modify email: Not login');
			exit;
		}

		self::checkPOST();
		$email = filter_var(\SSF\Router::POST('data'), FILTER_VALIDATE_EMAIL);

		if ($email === false) {
			echo '{"status":"fail","msg":"Invalid email"}';
			\SSF\Option::addHistory('[Fail] Modify email: Invalid email');
			exit;
		}

		\SSF\Option::set('email', $email);
		\SSF\Option::addHistory('[Success] Modify email');

		echo '{"status":"success","msg":"Refresh to see your new gravatar"}';
	}
};
\SSF\Action::register('ssf:modify_email', '\SSF\Action\ModifyEmail');

class ModifyGravatarUrl implements \SSF\ActionInterface {
	static private function checkPOST(): void {
		if (\SSF\Router::POST('data') === false) {
			echo '{"status":"fail","msg":"Invalid POST"}';
			\SSF\Option::addHistory('[Fail] Modify gravatar url: Invalid POST');
			exit;
		}
	}

	static public function run(): void {
		if (!\SSF\Session::isLogin()) {
			echo '{"status":"fail","msg":"Please login"}';
			\SSF\Option::addHistory('[Fail] Modify gravatar url: Not login');
			exit;
		}

		self::checkPOST();
		$url = \SSF\Router::POST('data');

		if ($url !== '' && filter_var($url, FILTER_VALIDATE_URL) === false) {
			echo '{"status":"fail","msg":"Invalid url"}';
			\SSF\Option::addHistory('[Fail] Modify gravatar url: Invalid email');
			exit;
		}

		\SSF\Option::set('gravatar_url', $url);
		\SSF\Option::addHistory('[Success] Modify gravatar url');

		echo '{"status":"success","msg":"Refresh to see your new gravatar"}';
	}
};
\SSF\Action::register('ssf:modify_gravatar_url', '\SSF\Action\ModifyGravatarUrl');

class ModifyMaxHistory implements \SSF\ActionInterface {
	static private function checkPOST(): void {
		if (\SSF\Router::POST('data') === false) {
			echo '{"status":"fail","msg":"Invalid POST"}';
			\SSF\Option::addHistory('[Fail] Modify max history: Invalid POST');
			exit;
		}
	}

	static public function run(): void {
		if (!\SSF\Session::isLogin()) {
			echo '{"status":"fail","msg":"Please login"}';
			\SSF\Option::addHistory('[Fail] Modify max history: Not login');
			exit;
		}

		self::checkPOST();
		$lmt = filter_var(\SSF\Router::POST('data'), FILTER_VALIDATE_INT, ["options" => ["min_range" => 15]]);

		if ($lmt === false) {
			echo '{"status":"fail","msg":"Invalid number, requires an integer equal or greater than 15"}';
			\SSF\Option::addHistory('[Fail] Modify max history: Invalid value');
			exit;
		}

		\SSF\Option::set('max_history', $lmt);
		\SSF\Option::addHistory('[Success] Modify max history');

		echo '{"status":"success"}';
	}
};
\SSF\Action::register('ssf:modify_max_history', '\SSF\Action\ModifyMaxHistory');

class ClearHistory implements \SSF\ActionInterface {
	static public function run(): void {
		if (!\SSF\Session::isLogin()) {
			echo '{"status":"fail","msg":"Please login"}';
			\SSF\Option::addHistory('[Fail] Clear history: Not login');
			exit;
		}

		\SSF\Option::clearHistory();
		\SSF\Option::addHistory('[Success] Clear history');

		echo '{"status":"success"}';
	}
};
\SSF\Action::register('ssf:clear_history', '\SSF\Action\ClearHistory');
