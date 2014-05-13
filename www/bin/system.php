<?php
 header("Content-type: text/plain");
 
if(isset($_REQUEST['act']) && $_REQUEST['act']!="")
{
$act=$_REQUEST['act'];


$toShell= exec("sudo /var/www/bin/system.sh $act",$out);

echo $toShell;


}
?>
