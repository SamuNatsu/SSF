<?php
namespace SSF\Action;

class Login implements \SSF\ActionInterface {
	static public function run(): void {
		$pass = \SSF\Router::POST('password');
		$hist = \SSF\Options::get('login-history');

		if (\SSF\Options::get('password') === $pass) {
			\SSF\Session::set('login', true);
			\SSF\Session::set('login_time', time());

			array_push($hist, [
				'time' => time(),
				'ip' => \SSF\Session::getClientIP(),
				'status' => 'Success'
			]);
			echo '{"status":"success","href":"' . \SSF\Path::url('admin', '/?page=dashboard') . '"}';
		}
		else {
			array_push($hist, [
				'time' => time(),
				'ip' => \SSF\Session::getClientIP(),
				'status' => 'Wrong password'
			]);
			echo '{"status":"fail","msg":"Wrong password"}';
		}
		if (count($hist) > 50)
			array_shift($hist);
		\SSF\Options::set('login-history', $hist);
		\SSF\Options::update();
	}
};
\SSF\Action::register('ssf:login', '\SSF\Action\Login');
