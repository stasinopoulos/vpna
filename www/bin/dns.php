<?php
$prim=$_REQUEST['primaryDNS'];
$sec=$_REQUEST['secDNS'];


$toShell= exec("sudo ./dns.sh $prim $sec",$out);

echo $toShell;
?>
