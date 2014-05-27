<?php

if(isset($_REQUEST['act']) && $_REQUEST['act']!="")
{


$act=$_REQUEST['act'];

$toShell= exec("sudo ./proxy.sh $act",$out);

echo $toShell;

}

?>
