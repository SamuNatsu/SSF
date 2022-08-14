<?php
// Check flag
if (!defined('__SSF__')) exit;

// Check login
if (\SSF\Session::get('login') === true)
	\SSF\Router::jump(\SSF\Router::root('/?page=dashboard'));

// Add current path
\SSF\Router::addPath('current', \SSF\Router::root('/login'));

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php \SSF\Options::title('Login', true); ?></title>
	<link rel="stylesheet" href="<?php \SSF\Router::shared('/modern-normalize.min.css', true); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Router::shared('/flex.css', true); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Router::shared('/ssf.css', true); ?>"/>
	<script src="<?php \SSF\Router::shared('/jquery.min.js', true); ?>"></script>
	<script src="<?php \SSF\Router::shared('/hashes.min.js', true); ?>"></script>
	<script src="<?php \SSF\Router::current('/script.js', true); ?>" defer></script>
</head>
<body><div class="flex-box flex-x-center flex-mid flex-fixed">
	<div class="flex-box flex-col block hover-shadow">
		<div class="flex-box flex-x-center after-space"><h1>Login</h1></div>
		<div class="flex-box flex-col after-space">
			<div id="warning-password" class="warning"></div>
			<input id="form-password" type="password"/>
			<div class="description">Please input dashboard password</div>
		</div>
		<div class="flex-box flex-x-space after-space">
			<div id="btn-back" class="btn-1 btn-bl">Back to index</div>
			<div id="btn-login" class="btn-1 btn-bk">Login</div>
		</div>
		<div class="flex-box flex-x-right description footer-tag">Powered by Simple Site Framework</div>
	</div>
</div></body>
</html>
