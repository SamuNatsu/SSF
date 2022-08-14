<?php
namespace SSF\Action;

class Logout implements \SSF\ActionInterface {
	static public function run(): void {
		\SSF\Session::stop();
		echo '{"href":"' . \SSF\Router::root('/?page=login') . '"}';
	}
};
