<?php

$act=$_REQUEST['act'];
$log=$_REQUEST['logSelect'];
$lines=$_REQUEST['lines'];
$find=$_REQUEST['find'];

exec("sudo ./logs.sh $act $log $lines '$find'",$out);

switch($act){
 case "list":{ echo "logs=['". implode("','",$out) ."']\n"; break; }
 default:{ echo implode("\n",$out); }
}

?>
