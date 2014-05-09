<?php

$act=$_REQUEST['_act'];
$port=$_REQUEST['portNum'];

exec("sudo ./proxy.sh $act $port",$out);

?>
