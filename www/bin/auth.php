<?php
$userName=$_REQUEST['vpnaUsername'];
$userPass=$_REQUEST['vpnaUserpass'];
$password = crypt($userPass, base64_encode($userPass));
file_put_contents("/var/www/sys/net.auth", $userName:$password)
echo "res={ sabai: 1, msg: 'Credentials Updated' };";
?>