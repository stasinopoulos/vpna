<?php

if(isset($_REQUEST['act']) && $_REQUEST['act']!="" && isset($_REQUEST['portNum']) && $_REQUEST['portNum']!="")
{


$act=$_REQUEST['act'];
$port=$_REQUEST['portNum'];


$toShell= exec("sudo ./proxy.sh $act $port",$out);

echo $toShell;

}

?>
