<?php
// Initialize flags
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
define('__SSF__', '');

// Require components
require_once('../var/Action.php');
require_once('../var/Path.php');
require_once('../var/Router.php');

// Check installed
if (is_file('../config.php')) exit;

// Initialize paths
\SSF\Path::setDir('admin', '../admin');
\SSF\Path::setDir('var', '../var');
\SSF\Path::setDir('shared', '../shared');
\SSF\Path::setDir('www', '../');

// Register install page
require_once('./action.php');
\SSF\Action::register('ssf:install', '\SSF\Action\Install');
\SSF\Router::addPage('', './page.php');

// Despatch
\SSF\Router::despatch();
