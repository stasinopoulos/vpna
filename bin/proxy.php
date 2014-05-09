<?php

$act=$_REQUEST['proxyStatus'];
$port=$_REQUEST['portNum'];

exec("sudo ./proxy.sh $act $port",$out);

?>
