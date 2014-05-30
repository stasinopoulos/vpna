<?php
$oldPass=$_REQUEST['vpnaOldpass'];
$userPass=$_REQUEST['vpnaPassword'];
$current = crypt($oldPass, base64_encode($oldPass));
$password = crypt($userPass, base64_encode($userPass));
$validate= file_get_contents("/var/www/sys/net.aut");

if ($current == $validate) {
  file_put_contents("/var/www/sys/net.aut", "sabai" .":". $password);
  echo "res={ sabai: 1, msg: 'Credentials Updated' };";
} else {
  echo "res={ sabai: 0, msg: 'Credentials Validation Failed' };";
}
?>
