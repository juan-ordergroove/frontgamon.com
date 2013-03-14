<?php
require_once (PHP_DEV . 'admin/session.inc.php');
session_destroy();
header(sprintf('Location: http://%s/login.php', $_SERVER['HTTP_HOST']));
?>
