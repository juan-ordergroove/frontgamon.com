<?php
require_once (PHP_LIVE . 'admin/session.inc.php');
session_destroy();
$host = $_SERVER['HTTP_HOST'];
header("Location: http://$host/");
?>