<?php
if ($_POST['phonegap_test'] == true) {
  echo 'here is what you posted';
  echo $_POST['phonegap_test'];
} else {
  echo 'no post data detected';
}
?>
