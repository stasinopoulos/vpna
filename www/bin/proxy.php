<?php

$act=$_REQUEST['_act'];
$port=$_REQUEST['portNum'];

$toShell= exec("sudo ./proxy.sh $act $port",$out);

echo $toShell;

?>
