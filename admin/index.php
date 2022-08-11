<?php 
// Initialize flags
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);

// Check installed
if (!is_file('../config.php')) {
	header('Location: /install');
	exit;
}
require_once('../config.php');

// Initialize components
require_once('../var/SleekDB/SleekDB.php');
$DB = new \SleekDB\store($DB_NAME, '../', ['timeout' => false]);

require_once('../var/Options.php');
\SSF\Options::init();

require_once('../var/Router.php');
$Router = new \SSF\Router(__DIR__);
$Router->set('404', '../shared/404.php');
$Router->set('', '../shared/')

// Router despatch
if ($Router->)
$Router->despatch();
