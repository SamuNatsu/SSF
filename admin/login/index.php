<?php
// Check flag
if (!defined('__SSF__')) exit;

// Check login
if (\SSF\Session::get('login') === true)
	\SSF\Router::jump(\SSF\Path::url('admin', '/?page=dashboard'));

// Set root
\SSF\Path::setRootDir(__DIR__);

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php \SSF\Options::title('Login', true); ?></title>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/modern-normalize.min.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/flex.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/ssf-ui.css'); ?>"/>
	<script src="<?php \SSF\Path::_url('shared', '/jquery.min.js'); ?>"></script>
	<script src="<?php \SSF\Path::_url('shared', '/hashes.min.js'); ?>"></script>
	<script src="<?php \SSF\Path::_url('root', '/script.js'); ?>" defer></script>
</head>
<body><div class="fixed-frame flex-box flex-x-center flex-mid">
	<div class="container width-30 flex-box flex-col">
		<div class="flex-box flex-x-center"><h1>Login</h1></div>
		<hr class="hr-dashed"/>
		<div class="flex-box flex-col after-space">
			<div id="warning-password" class="warning"></div>
			<input id="form-password" type="password"/>
			<div class="description">Please input dashboard password</div>
		</div>
		<div class="flex-box flex-x-space">
			<div id="btn-back" class="btn btn-blue">Back to index</div>
			<div id="btn-login" class="btn btn-black">Login</div>
		</div>
	</div>
</div></body>
</html>
