<?php
namespace SSF\Action;

class Logout implements \SSF\ActionInterface {
	static public function run(): void {
		\SSF\Session::stop();
		echo '{"href":"' . \SSF\Path::url('admin', '/') . '"}';
	}
};
\SSF\Action::register('ssf:logout', '\SSF\Action\Logout');

class ModifyEmail implements \SSF\ActionInterface {
	static public function run(): void {
		if (!\SSF\Session::isLogin()) {
			echo '{"status":"fail","msg":"Please login"}';
			return;
		}

		$email = \SSF\Router::POST('email');
		if ($email === false) {
			echo '{"status":"fail","msg":"Invalid POST"}';
			return;
		}
		$email = trim($email);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo '{"status":"fail","msg":"Invalid email"}';
			return;
		}

		\SSF\Options::set('email', $email);
		\SSF\Options::update();

		echo '{"status":"success"}';
	}
};
\SSF\Action::register('ssf:modify_email', '\SSF\Action\ModifyEmail');
