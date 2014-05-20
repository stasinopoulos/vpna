<?php

$act=$_REQUEST['act'];
switch($act){
 case 1:{
  $ip = $_REQUEST['ip'];
  $count = $_REQUEST['count'];
  $size = $_REQUEST['size'];
  $ex="ping $ip -c $count";
 break; }
 case 2:
  $ip = $_REQUEST['ip'];
  $count = $_REQUEST['count'];
  $size = $_REQUEST['size'];
  $ex="traceroute $ip". ($count==30?"":" -m $count") . ($size=="5"?"":"-w $size");
 break;
 case 3:{ $ex="route -n";
 break; }
 case 4:{ $ex=str_replace("\r","\n",$_REQUEST['cmd']);
 break; }
}

 $rname="/tmp/tmp.". str_pad(mt_rand(1000,9999), 4, "0", STR_PAD_LEFT)  .".sh";
 file_put_contents($rname,"#!/bin/bash\nexport PATH='/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin'\n$ex\n");
 exec("bash $rname",$out);
 header("Content-type: text/plain");
 echo (unlink($rname)?"":"There was an error when trying to delete the file $rname.\n") . implode("\n",$out);
?>
