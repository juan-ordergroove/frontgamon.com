<?php
session_start();
$host = $_SERVER["HTTP_HOST"];
$nameSpace = '';

if (strpos($host, 'stupidsh.'))
		$nameSpace = 'SHT';
else if(strpos($host, 'frontgamon.'))
		$nameSpace = 'FG';
else if(strpos($host, 'theshortybus.'))
		$nameSpace = 'SB';

// THIS IS BASICALLY IMPOSSIBLE (I believe...)
if (!strlen($nameSpace))
		header("Location: http://google.com");

if (empty($_SESSION))
	header("Location: http://" . $host . "/login.php");
else if (!isset($_SESSION['Users']))
	header("Location: http://" . $host . "/login.php");
else if (md5($_SESSION['Users']) != $_SESSION['fingerprint'])
	header("Location: http://" . $host . "/login.php");

/*
 * When we include this section of code, you get class Object redefinition errors
require_once (PHP_LIVE . 'classes/' . $nameSpace . '/Users.class.php');
$className = 'Users';
$adminUser = new $className();
$adminUser = unserialize($_SESSION['Users']);
*/
?>
