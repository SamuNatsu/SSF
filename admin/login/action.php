<?php
namespace SSF\Action;

class Login implements \SSF\ActionInterface {
	static private function checkPOST(): void {
		if (\SSF\Router::POST('password') === false) {
			echo '{"status":"fail","msg":"Invalid POST"}';
			\SSF\Option::addHistory("[Fail] Login: Invalid POST");
			exit;
		}
	}

	static public function run(): void {
		self::checkPOST();
		$pass = \SSF\Router::POST('password');

		if (\SSF\Session::isLogin()) {
			echo '{"status":"fail","msg":"Already logined"}';
			\SSF\Option::addHistory("[Fail] Login: Already logined");
			exit;
		}

		if (\SSF\Option::get('password') === $pass) {
			\SSF\Session::setLogin();
			\SSF\Option::addHistory('[Success] Login');
			echo '{"status":"success"}';
		}
		else {
			\SSF\Option::addHistory("[Fail] Login: Wrong password");
			echo '{"status":"fail","msg":"Wrong password"}';
		}
	}
};
\SSF\Action::register('ssf:login', '\SSF\Action\Login');
