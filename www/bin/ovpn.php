<?php
header('Content-Type: application/javascript');

function newfile(){
 $file = ( array_key_exists('file',$_FILES) && array_key_exists('name',$_FILES['file']) ? $_FILES['file']['name'] : "" );
 $contents = ( array_key_exists('file',$_FILES) && array_key_exists('tmp_name',$_FILES['file']) ? file_get_contents($_FILES['file']['tmp_name']) : "" );
 $type = strrchr($file,".");

 switch($type){
  case ".sh":
   $contents = stristr(stristr($contents,"nvram set ovpn_cfg='"),"'");
   $contents = trim( substr( $contents, 0, stripos($contents,"nvram set ovpn") ), "\n'");
   $contents = preg_replace(array("/^script-security.*/m","/^route-up .*/m","/^up .*/m","/^down .*/m"),"",$contents);
  case ".conf":
  case ".ovpn":
   file_put_contents("/var/www/usr/ovpn.current",$contents);
   file_put_contents("/var/www/usr/ovpn","{ file: '$file', res: { sabai: true, msg: 'OpenVPN $type file loaded.' } }");
  break;
  default:{
   file_put_contents("/var/www/usr/ovpn","{ file: '', res: { sabai: false, msg: 'OpenVPN file failed.' } }");
  }
 }
 header("Location: /sabaivpn-ovpn.php");
}

function savefile(){
$name=$_REQUEST['VPNname'];
$password=$_REQUEST['VPNpassword'];
 if(array_key_exists('conf',$_REQUEST)){
  file_put_contents("/var/www/usr/ovpn.current",$_REQUEST['conf']);
  file_put_contents("/var/www/usr/auth-pass",$name ."\n");
  file_put_contents("/var/www/usr/auth-pass",$password, FILE_APPEND);
  exec("sudo sed -ir 's\auth-user-pass.*$\auth-user-pass /var/www/usr/auth-pass\g' /var/www/usr/ovpn.current");
  echo "res={ sabai: true, msg: 'OpenVPN configuration saved.', reload: true };";
 }else{
  echo "res={ sabai: false, msg: 'Invalid configuration.' };";
 }
}


$act=$_REQUEST['act'];
switch ($act){
	case "start":
		if(!file_exists("/var/www/usr/ovpn.current")){ echo "res={ sabai: false, msg: 'OpenVPN file missing.' };"; break; }
	case "stop":
		$line=exec("sudo /var/www/bin/ovpn.sh $act 2>&1",$out);
		$i=count($out)-1;
		while( substr($line,0,3)!="res" && $i>=0 ){ $line=$out[$i--]; }
		file_put_contents("/var/www/stat/php.ovpn.log", implode("\n",$out) );
		echo $line;
	break;
	case "erase":
		unlink("/var/www/usr/ovpn.current");
		unlink("/var/www/stat/ovpn.log");
		unlink("/var/www/stat/ovpn.connected");
		unlink("/var/www/usr/auth-pass");
		exec("sudo /var/www/bin/ovpn.sh erase 2>&1");
		file_put_contents("/var/www/usr/ovpn","{ file: '' }");
		echo "res={ sabai: true, msg: 'OpenVPN file removed.', reload: true };";
	break;
	case "newfile": newfile(); break;
	case "save": savefile(); break;
	case "log": echo (file_exists("/var/www/stat/ovpn.log") ? str_replace(array("\"","\r"),array("'","\n"),file_get_contents("/var/www/stat/ovpn.log")) : "No log."); break;
}

?>
