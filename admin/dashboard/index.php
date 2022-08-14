<?php
// Check flag
if (!defined('__SSF__')) exit;

// Check is login
if (\SSF\Session::get('login') !== true) {
	header('Location: ' . \SSF\Router::root('/?page=login'));
	exit;
}

// Add current path
\SSF\Router::addPath('current', \SSF\Router::root('/dashboard'));

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php \SSF\Options::title('Dashboard', true); ?></title>
	<link rel="stylesheet" href="<?php \SSF\Router::shared('/modern-normalize.min.css', true); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Router::shared('/flex.css', true); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Router::shared('/ssf.css', true); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Router::shared('/ssf-ui.css', true); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Router::current('/style.css', true); ?>"/>
	<script src="<?php \SSF\Router::shared('/jquery.min.js', true); ?>"></script>
	<script src="<?php \SSF\Router::shared('/hashes.min.js', true); ?>"></script>
	<script src="<?php \SSF\Router::current('/script.js', true); ?>" defer></script>
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
		<div class="container width-70">
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
		<div class="container width-70">
			<h1>My info</h1>
			<hr class="hr-dashed"/>
			<div class="flex-box">
				<img id="my-gravatar" class="width-30" src="as"/>
				<div class="flex-box flex-col width-70 pad-10">
					<h3>E-mail</h3>
					<div id="form-email" class="modifiable after-space">
						<div>abs@123.com</div>
						<div class="modifiable-btn">Modify</div>
					</div>
					<h3>Gravatar URL</h3>
					<div id="form-email" class="modifiable after-space">
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
