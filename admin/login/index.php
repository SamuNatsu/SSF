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
	<title><?php \SSF\Option::_title('Login'); ?></title>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/modern-normalize.min.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/ssf-flex.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/ssf-ui.css'); ?>"/>
	<script src="<?php \SSF\Path::_url('shared', '/jquery.min.js'); ?>"></script>
	<script src="<?php \SSF\Path::_url('shared', '/hashes.min.js'); ?>"></script>
	<script src="<?php \SSF\Path::_url('root', '/script.js'); ?>" defer></script>
</head>
<body><div class="layout-fixed flex-center">
	<div class="layout-list container width-30">
		<h1 class="text-center">Login</h1>
		<hr class="hr-dashed"/>
		<div class="layout-list">
			<input id="i-password" type="password"/>
			<div class="text-desc">Please input dashboard password</div>
		</div>
		<div class="layout-space margin-t-40">
			<div id="b-back" class="btn btn-blue">Back to index</div>
			<div id="b-login" class="btn">Login</div>
		</div>
	</div>
</div></body>
</html>
