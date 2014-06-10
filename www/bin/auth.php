<?php
$userPass=$_REQUEST['vpnaPassword'];
$password = crypt($userPass);

file_put_contents("/var/www/sys/net.aut", "sabai" .":". $password);
echo "res={ sabai: 1, msg: 'Credentials Updated' };";
?>
