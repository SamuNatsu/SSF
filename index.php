<?php
// Initialize
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);

// Check installed
if (!is_file('./config.php')) {
	header('Location: /install');
	exit;
}
