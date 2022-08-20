<?php
namespace SSF\Action;

class Login implements \SSF\ActionInterface {
	static private function checkPOST(): void {
		if (\SSF\Router::POST('password') === false) {
			echo '{"status":"fail","msg":"Invalid POST"}';
			exit;
		}
	}

	static public function run(): void {
		self::checkPOST();
		$pass = \SSF\Router::POST('password');

		if (\SSF\Options::getPassword() === $pass) {
			\SSF\Session::setLogin();
			\SSF\Options::addLoginHistory('Success');
			echo '{"status":"success","href":"' . \SSF\Path::url('admin', '/?page=dashboard') . '"}';
		}
		else {
			\SSF\Options::addLoginHistory("Wrong password");
			echo '{"status":"fail","msg":"Wrong password"}';
		}
	}
};
\SSF\Action::register('ssf:login', '\SSF\Action\Login');
