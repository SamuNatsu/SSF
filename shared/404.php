<?php 
// Check flag
if (!defined('__SSF__')) exit;

// Set root
\SSF\Path::setRootDir(__DIR__);

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php \SSF\Option::title('404', true); ?></title>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('root', '/modern-normalize.min.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('root', '/ssf-flex.css'); ?>"/>
	<style>
		body {color:lightgray;font-weight:bold;height:100%;position:absolute;width:100%}
		.text-1 {font-size:8em}
		.text-2 {font-size:2em}
	</style>
</head>
<body class="flex-box flex-center">
	<div class="flex-box flex-c-baseline">
		<div class="text-1">404</div>
		<div class="flex-box flex-rev-col">
			<div class="text-2">Found</div>
			<div class="text-2">Not</div>
		</div>
	<div>
</body>
</html>
