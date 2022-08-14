<?php
namespace SSF\Action;

class Login implements \SSF\ActionInterface {
	static public function run(): void {
		$pass = \SSF\Router::POST('password');
		$hist = \SSF\Options::get('login_history');
		if (!is_array($hist))
			$hist = [];

		if (\SSF\Options::get('password') === $pass) {
			\SSF\Session::set('login', true);
			\SSF\Session::set('login_time', time());
			
			array_push($hist, [
				'time' => time(),
				'ip' => \SSF\Session::getClientIP(),
				'status' => 'Success'
			]);
			echo '{"status":"success","href":"' . \SSF\Router::root('/?page=dashboard') . '"}';
		}
		else {
			array_push($hist, [
				'time' => time(),
				'ip' => \SSF\Session::getClientIP(),
				'status' => 'Wrong password'
			]);
			echo '{"status":"fail","msg":"Wrong password"}';
		}
		\SSF\Options::set('login_history', $hist);
		\SSF\Options::update();
	}
};
