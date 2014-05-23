<?php
header('Content-Type: application/javascript');

$act=$_REQUEST['act'];
$user=trim($_REQUEST['user']);
$pass=trim($_REQUEST['pass']);
$psk=trim($_REQUEST['psk']);
$server=trim($_REQUEST['server']);
$serverip=trim(gethostbyname($server));

switch ($act) {
        case "cancel":
                unlink("/var/www/usr/l2tp");
                echo "res={ sabai: true, msg : 'Settings cleared.' }";
                break;
	case "start":
	case "stop":
		$line=exec("sudo ./l2tp.sh $act $user $pass $psk $serverip 2>&1",$out);
		$i=count($out)-1;
		while( substr($line,0,3)!="res" && $i>=0 ){ $line=$out[$i--]; }
		file_put_contents("/var/www/log/php.l2tp.log", implode("\n",$out) );
		echo $line;
	case "save":
		file_put_contents("/var/www/usr/l2tp","$user $pass $psk $serverip");
		if($act=="save") echo "res={ sabai: true, msg: 'Settings saved.' }";
}

?>
