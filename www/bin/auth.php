<?php
$oldPass=$_REQUEST['vpnaOldpass'];
$userPass=$_REQUEST['vpnaPassword'];
$password = crypt($userPass, base64_encode($userPass));
file_put_contents("/var/www/sys/net.aut", "sabai" .":". $password)
echo "res={ sabai: 1, msg: 'Credentials Updated' };";
?>