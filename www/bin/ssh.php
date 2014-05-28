<?php
	header("Content-type: text/plain");
		 
	if(isset($_REQUEST['act']) && $_REQUEST['act']!="")
	{
		$act=$_REQUEST['act'];

		$toDo= exec("sudo /var/www/bin/ssh.sh $act",$out);

		echo $toDo;
	}
?>
