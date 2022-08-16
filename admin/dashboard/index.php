<?php
// Check flag
if (!defined('__SSF__')) exit;

// Check is login
if (\SSF\Session::get('login') !== true) {
	header('Location: ' . \SSF\Path::url('admin', '/'));
	exit;
}

// Set root
\SSF\Path::setRootDir(__DIR__);

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php \SSF\Options::title('Dashboard', true); ?></title>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/modern-normalize.min.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/flex.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/ssf-ui.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('root', '/style.css'); ?>"/>
	<script src="<?php \SSF\Path::_url('shared', '/jquery.min.js'); ?>"></script>
	<script src="<?php \SSF\Path::_url('shared', '/hashes.min.js'); ?>"></script>
	<script src="<?php \SSF\Path::_url('root', '/script.js'); ?>" defer></script>
</head>
<body><div class="fixed-frame flex-col">
	<nav class="nav-bar">
		<div current>Dashboard</div>
		<div>Settings</div>
		<div>Plugins</div>
		<div>Posts</div>
		<div>Categories</div>
		<div>Tags</div>
		<div>Links</div>
		<div>Attachments</div>
		<div id="nav-btn-logout">Log out</div>
	</nav>
	<div class="scrollable">
		<div class="container width-70 before-space">
			<h1>Statistics</h1>
			<hr class="hr-dashed"/>
			<table class="tb-no-border width-70 table-statistics">
				<thead><tr>
					<th>Posts</th>
					<th>Categories</th>
					<th>Tags</th>
					<th>Links</th>
				</tr></thead>
				<tbody><tr>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
				</tr></tbody>
			</table>
			<table class="tb-no-border width-70 table-statistics">
				<thead><tr>
					<th>Activated plugins</th>
					<th>Views</th>
				</tr></thead>
				<tbody><tr>
					<td><?php echo count(\SSF\Options::get('activated-plugin')); ?></td>
					<td>0</td>
				</tr></tbody>
			</table>
		</div>
		<div class="container width-70 before-space">
			<h1>My info</h1>
			<hr class="hr-dashed"/>
			<div class="flex-box">
				<div class="width-30 flex-box flex-x-center flex-top">
					<img id="my-gravatar" src="<?php echo \SSF\Options::gravatar(); ?>"/>
				</div>
				<div class="flex-box flex-col width-70 pad-10">
					<h3>E-mail</h3>
					<div id="form-email" class="modifiable after-space">
						<div id="form-email-val"><?php echo \SSF\Options::get('email'); ?></div>
						<div class="modifiable-btn" activate="0">Modify</div>
					</div>
					<h3>Gravatar URL</h3>
					<div id="form-gravatar-url" class="modifiable after-space">
						<div>(Use e-mail and online gravatar services)</div>
						<div class="modifiable-btn">Modify</div>
					</div>
					<h3>Recent login history</h3>
					<table class="tb-normal width-100 login-history">
						<thead><tr>
							<th>Time</th>
							<th>IP</th>
							<th>Status</th>
						</tr></thead>
						<tbody><?php
							$hist = \SSF\Options::get('login_history');
							for ($i = count($hist) - 1; $i >= 0; $i--) {
								$tm = date("Y/m/d H:i:s", $hist[$i]['time']);
								echo "<tr><td>$tm</td><td>{$hist[$i]['ip']}</td><td>{$hist[$i]['status']}</td></tr>";
							}
							unset($hist);
						?></tbody>
					</table>
				</div>
			</div>
		</div>
		<footer></footer>
	</div>
</div></body>
</html>
