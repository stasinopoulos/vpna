<?php
$prim=$_REQUEST['primaryDNS'];
$sec=$_REQUEST['secDNS'];

file_put_contents("/var/www/sys/net.aut", "dns-nameservers " . $prim . " " . $sec);
echo "res={ sabai: 1, msg: 'Credentials Updated' };";
?>
