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
		<div class="nav-item" data-href="dashboard">Dashboard</div>
		<div class="nav-item" data-href="settings">Settings</div>
		<div class="nav-item" data-href="plugins">Plugins</div>
		<div class="nav-item nav-item-current" data-href="posts">Posts</div>
		<div class="nav-item" data-href="categories">Categories</div>
		<div class="nav-item" data-href="tags">Tags</div>
		<div class="nav-item" data-href="links">Links</div>
		<div class="nav-item" data-href="attachments">Attachments</div>
		<div class="nav-item" id="b-logout">Log out</div>
	</nav>
	<div class="layout-list layout-skip-nav flex-c-center">
		<div class="container width-70">
			<?php $posts = \SSF\Meta::getPosts(); ?>
			<div class="layout-side flex-bottom">
				<h1>All posts (<?php echo count($posts);?>)</h1>
				<div class="btn btn-mini btn-green">Create New</div>
			</div>
			<table class="tb tb-normal width-100">
				<thead><tr><th>Title</th><th>Category</th><th>Tags</th><th>Create date</th><th>Last modify</th></tr></thead>
				<tbody>
				<?php foreach ($posts as $i): ?><tr>
					<td><?php echo $i['title']; ?></td>
					<td><?php echo \SSF\Meta::getCategoryById($i['category'])['name']; ?></td>
					<td><?php echo \SSF\Meta::getTagsString($i['tags']); ?></td>
					<td><?php \SSF\Option::_date($i['create_time']); ?></td>
					<td><?php \SSF\Option::_date($i['modify_time']); ?></td>
				</tr><?php endforeach; ?>
				</tbody>
			</table>
			<?php unset($posts); ?>
		</div>
	</div>
	<footer></footer>
</div></body>
</html>
