<?php

$act=$_REQUEST['_act'];

exec("sudo ./system.sh $act ",$out);

?>
