<?php 
// Initialize flags
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);

// Check installed
if (!is_file('../config.php')) exit;
require_once('../config.php');

// Initialize components
require_once('../var/SleekDB/SleekDB.php');
$DB = new \SleekDB\store($DB_NAME, '../', ['timeout' => false]);

require_once('../var/Action.php');

require_once('../var/Options.php');
\SSF\Options::init();

require_once('../var/Router.php');
\SSF\Router::init(__DIR__);

// Initialize pages
\SSF\Router::addPage('404', '../shared/404.php');

\SSF\Router::addPage('login', './login/index.php');
require_once('./login/action.php');
\SSF\Action::register('ssf', 'login', '\\SSF\\Action\\Login');

\SSF\Router::addPage('dashboard', './dashboard/index.php');
require_once('./dashboard/action.php');
\SSF\Action::register('ssf', 'logout', '\\SSF\\Action\\Logout');

\SSF\Router::addPath('shared', \SSF\Router::root('/../shared'));

require_once('../var/Session.php');

\SSF\Session::start();

// Router despatch
if (\SSF\Router::GET('page') === false && \SSF\Router::GET('action') === false)
	\SSF\Router::jump(\SSF\Router::root('/?page=login'));
else
	\SSF\Router::despatch();
