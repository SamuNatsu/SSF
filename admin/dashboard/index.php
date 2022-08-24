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
	<title><?php \SSF\Option::_title('Dashboard'); ?></title>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/modern-normalize.min.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/ssf-flex.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('shared', '/ssf-ui.css'); ?>"/>
	<link rel="stylesheet" href="<?php \SSF\Path::_url('root', '/style.css'); ?>"/>
	<script src="<?php \SSF\Path::_url('shared', '/jquery.min.js'); ?>"></script>
	<script src="<?php \SSF\Path::_url('shared', '/ssf-script.js'); ?>"></script>
	<script src="<?php \SSF\Path::_url('root', '/script.js'); ?>" defer></script>
</head>
<body>
	<nav class="nav top-nav">
		<div class="nav-item nav-item-current" data-href="dashboard" current>Dashboard</div>
		<div class="nav-item" data-href="settings">Settings</div>
		<div class="nav-item" data-href="plugins">Plugins</div>
		<div class="nav-item" data-href="posts">Posts</div>
		<div class="nav-item" data-href="categories">Categories</div>
		<div class="nav-item" data-href="tags">Tags</div>
		<div class="nav-item" data-href="links">Links</div>
		<div class="nav-item" data-href="attachments">Attachments</div>
		<div class="nav-item" id="b-logout">Log out</div>
	</nav>
	<div class="layout-list layout-skip-nav flex-c-center">
		<div class="container width-70">
			<h1>Statistics</h1>
			<hr class="hr-dashed"/>
			<table class="tb width-90 table-statistics">
				<thead><tr><th>Posts</th><th>Categories</th><th>Tags</th><th>Links</th><th>Activated Plugins</th></tr></thead>
				<tbody><tr>
					<td><?php echo \SSF\Meta::getPostCount(); ?></td>
					<td><?php echo \SSF\Meta::getCategoryCount(); ?></td>
					<td><?php echo \SSF\Meta::getTagCount(); ?></td>
					<td><?php echo \SSF\Meta::getLinkCount(); ?></td>
					<td>NaN</td>
				</tr></tbody>
			</table>
		</div>
		<div class="container width-70">
			<h1>My info</h1>
			<hr class="hr-dashed"/>
			<div class="flex-box">
				<div class="flex-box flex-m-center flex-c-top width-30">
					<img id="img-gravatar" src="<?php \SSF\Option::_gravatar(); ?>"/>
				</div>
				<div class="layout-list width-70 padding-10">
					<!-- Email -->
					<div class="ssf-i-modify" data-action="ssf:modify_email">
						<h3>Email</h3>
						<div class="ssf-i-modify-main">
							<div class="ssf-i-modify-field"><?php echo \SSF\Option::get('email'); ?></div>
							<div class="ssf-i-modify-btn">Modify</div>
						</div>
						<div class="text-desc"></div>
					</div>
					<hr class="hr-dashed"/>
					<!-- Gravatar URL -->
					<div class="ssf-i-modify" data-action="ssf:modify_gravatar_url">
						<h3>Gravatar URL</h3>
						<div class="ssf-i-modify-main">
							<div class="ssf-i-modify-field"><?php echo \SSF\Option::get('gravatar_url'); ?></div>
							<div class="ssf-i-modify-btn">Modify</div>
						</div>
						<div class="text-desc">If empty, online gravatar service would be used as your gravatar url</div>
					</div>
					<hr class="hr-dashed"/>
					<!-- Max history -->
					<div class="ssf-i-modify" data-action="ssf:modify_max_history">
						<h3>Max history</h3>
						<div class="ssf-i-modify-main">
							<div class="ssf-i-modify-field"><?php echo \SSF\Option::get('max_history'); ?></div>
							<div class="ssf-i-modify-btn">Modify</div>
						</div>
						<div class="text-desc">At least 15</div>
					</div>
					<hr class="hr-dashed"/>
					<!-- Login history -->
					<?php $hist = \SSF\Option::getHistory(); ?>
					<div class="layout-side flex-bottom">
						<h3>Action history (<?php echo count($hist); ?>)</h3>
						<div id="b-clear-history" class="btn btn-mini btn-red">Clear</div>
					</div>
					<table class="tb tb-normal width-100 login-history">
						<thead><tr><th>Time</th><th>IP</th><th>Action</th></tr></thead>
						<tbody>
						<?php foreach ($hist as $i): ?><tr>
							<td title="<?php \SSF\Option::_date($i['time']); ?>"><?php \SSF\Option::_date($i['time']); ?></td>
							<td title="<?php echo $i['ip']; ?>"><?php echo $i['ip']; ?></td>
							<td title="<?php echo $i['msg']; ?>"><?php echo $i['msg']; ?></td>
						</tr><?php endforeach; ?>
						</tbody>
					</table>
					<?php unset($hist); ?>
				</div>
			</div>
		</div>
	</div>
	<footer></footer>
</body>
</html>
