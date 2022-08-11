<?php
// Initialize flags
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
define('__SSF__', '');

// Check installed
if (is_file('../config.php')) {
	echo '{"status":"fail","msg":"SSF has been already installed"}';
	exit;
}

// Initialize components
require_once('../var/Router.php');
$Router = new \SSF\Router(__DIR__);

// Validate password
if (!isset($_POST['password'])) {
	echo '{"status":"fail","msg":"Invalid POST"}';
	exit;
}
$pass = $_POST['password'];
if (strlen($pass) < 6) {
	echo '{"status":"fail","msg":"Password length too short"}';
	exit;
}
if (!preg_match('/\d/', $pass)) {
	echo '{"status":"fail","msg":"Password MUST contains digit"}';
	exit;
}
if (!preg_match('/[a-zA-Z]/', $pass)) {
	echo '{"status":"fail","msg":"Password MUST contains letter"}';
	exit;
}
$pass = md5(sha1($pass));

// Generator config
$rcs = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_+';
$db = '';
for ($i = 0; $i < 20; $i++)
	$db .= $rcs[rand(0, 63)];
file_put_contents('../config.php', "<?php\ndefine('__SSF__', '');\n\$DB_NAME = '$db';");

// Initialize database
require_once('../var/SleekDB/SleekDB.php');
$store = new \SleekDB\Store($db, '../', ['timeout' => false]);
$store->insert([
	'db' => 'options', 
	'password' => $pass,
	'sitename' => 'Test site',
	'description' => 'Test description',
	'title-pattern' => '%title - %name'
]);

// Jump to dashboard
echo '{"status":"success","href":"' . $Router->root('/../admin') . '"}';
