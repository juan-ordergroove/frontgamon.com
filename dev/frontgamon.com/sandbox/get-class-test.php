<?php 
require_once(PHP_DEV . 'classes/SHT/Users.class.php');
?>

<html>
<head>
<title>
get_class() test
</title>
</head>
<body>

<?php
$user = new Users();
$rs = $user->FetchAllUsers();
$user->Init($rs);
$rs->Close();

$dump = new Dump($user);
?>

</body>
</html>