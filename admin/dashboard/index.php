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
	<title><?php \SSF\Options::_title('Dashboard'); ?></title>
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
					<td>0</td>
					<td>0</td>
				</tr></tbody>
			</table>
		</div>
		<div class="container width-70 before-space">
			<h1>My info</h1>
			<hr class="hr-dashed"/>
			<div class="flex-box">
				<div class="width-30 flex-box flex-x-center flex-top">
					<img id="my-gravatar" src="<?php \SSF\Options::_gravatar(); ?>"/>
				</div>
				<div class="flex-box flex-col width-70 pad-10">
					<!-- Email -->
					<div class="ssf-i-modify" data-active="0">
						<h3>Email</h3>
						<div class="ssf-i-modify-main">
							<div class="ssf-i-modify-field" data-field="email"><?php echo \SSF\Options::get('email'); ?></div>
							<div class="ssf-i-modify-btn" data-action="ssf:modify_email">Modify</div>
						</div>
					</div>
					<hr class="hr-dashed"/>
					<!-- Gravatar URL -->
					<div class="ssf-i-modify" data-active="0">
						<h3>Gravatar URL</h3>
						<div class="ssf-i-modify-main">
							<div class="ssf-i-modify-field" data-field="url"><?php echo \SSF\Options::get('gravatar_url'); ?></div>
							<div class="ssf-i-modify-btn" data-action="ssf:modify_gravatar_url">Modify</div>
						</div>
						<div class="ssf-st-desc">If empty, online gravatar service would be used as your gravatar url</div>
					</div>
					<hr class="hr-dashed"/>
					<!-- Max login history -->
					<div class="ssf-i-modify" data-active="0">
						<h3>Max login history</h3>
						<div class="ssf-i-modify-main">
							<div class="ssf-i-modify-field" data-field="limit"><?php echo \SSF\Options::getMaxLoginHistory(); ?></div>
							<div class="ssf-i-modify-btn" data-action="ssf:modify_max_login_history">Modify</div>
						</div>
						<div class="ssf-st-desc">Set 0 to disable history, set -1 to keep infinite history</div>
					</div>
					<hr class="hr-dashed"/>
					<!-- Login history -->
					<div class="flex-box flex-bottom flex-x-between">
						<h3>Recent login history</h3>
						<div id="form-clear-history" class="btn btn-red">Clear</div>
					</div>
					<table class="tb-normal width-100 login-history">
						<thead><tr><th>Time</th><th>IP</th><th>Status</th></tr></thead>
						<tbody><?php
							$hist = \SSF\Options::getLoginHistory();
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
