<?php
// Initialize flags
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);

// Require components
require_once('../var/SleekDB/SleekDB.php');
require_once('../var/Action.php');
require_once('../var/DB.php');
require_once('../var/Options.php');
require_once('../var/Path.php');
require_once('../var/Router.php');
require_once('../var/Session.php');

// Check installed
if (!is_file('../config.php')) exit;
require_once('../config.php');

// Initialize db
\SSF\DB::init();

// Initialize paths
\SSF\Path::setDir('admin', '../admin');
\SSF\Path::setDir('var', '../var');
\SSF\Path::setDir('shared', '../shared');
\SSF\Path::setDir('www', '../');

// Register 404 page
\SSF\Router::register('404', \SSF\Path::dir('shared', '/404.php'));

// Register login page
require_once('./login/action.php');
\SSF\Router::register('', './login/index.php');

// Register dashboard page
require_once('./dashboard/action.php');
\SSF\Router::register('dashboard', './dashboard/index.php');

// Start session
\SSF\Session::start();

// Despatch
\SSF\Router::despatch();
