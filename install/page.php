<?php 
// Check flag
if (!defined('__SSF__')) exit;

// Set root
\SSF\Path::setRootDir(__DIR__);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Install Simple Site Framework</title>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/modern-normalize.min.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/flex.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/ssf-ui.css'); ?>"/>
	<script src="<?php \SSF\Path::_url('shared', '/jquery.min.js'); ?>"></script>
	<script src="<?php \SSF\Path::_url('root', '/script.js'); ?>" defer></script>
</head>
<body><div class="flex-box flex-col">
	<header class="flex-box flex-x-center flex-mid hover-shadow">Install Simple Site Framework</header>
	<div class="container width-50 before-space">
		<h2>Intro</h2>
		<p><b>First, thanks for choosing our framework!</b></p>
		<p><em>Simple Site Framework</em> (aka SSF) is an open source framework that generate markdown web pages with custom theme templates, which enable users to easily maintain their site as a personal blog or personal wiki etc.</p>
		<p>SSF features in generating static html pages, no need for installed databases, easy to make themes and simple APIs.</p>
		<p>SSF uses other useful open source components, they're listed below:</p>
		<p><a href="https://github.com/rakibtg/SleekDB" target="_blank"><b>SleekDB</b></a>: File based php database (MIT Licensed)</p>
		<p><a href="https://github.com/erusev/parsedown" target="_blank"><b>Parsedown</b></a>: Markdown-Html parser (MIT Licensed)</p>
		<p>Special thanks to the maintainers of components above!</p>
		<p>The SSF version you install now is: <span class="warning">alpha 0.0.2</span></p>
	</div>
	<div class="container width-50 before-space">
		<h2>Dashboard password<span id="validate-password"></span></h2>
		<input id="form-password" type="password"/>
		<div class="description">Length &gt;= 6, contains digit and letter</div>
	</div>
	<button id="form-submit" class="btn btn-black before-space">Install</button>
	<footer></footer>
</div></body>
</html>