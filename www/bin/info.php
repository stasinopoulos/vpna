<?php
header('Content-Type: application/javascript');

 exec("/sbin/ifconfig eth0 | egrep -o \"HWaddr [A-Fa-f0-9:]*|inet addr:[0-9:.]*|UP BROADCAST RUNNING MULTICAST\"",$out);
$wan = " wan: {
  mac: '". strtoupper(str_replace("HWaddr ","", ( array_key_exists(0,$out)? "$out[0]" : "-" ) )) ."',
  ip: '". str_replace("inet addr:","", ( array_key_exists(1,$out)? "$out[1]" : "-" ) ) ."',
  status: '". ( array_key_exists(2,$out)? "Connected" : "-" ) ."' 
},\n";

unset($out);

if (file_exists ("/var/www/stat/proxy.connected")) {
  $proxy_status = rtrim (file_get_contents ("/var/www/stat/proxy.connected"));
} else {
  $proxy_status = "Proxy Stopped";
}
  
$proxy = " proxy: {
  status: '$proxy_status'
}";

unset($out);

exec("php get_remote_ip.php",$out);

$vo=array('pptp','l2tp','ovpn');
foreach($vo as &$v){ $v=file_exists("/var/www/stat/$v.connected")?$v:''; }
$vo=implode($vo);

switch($vo){
 case '': $vpn_type='-'; break;
 case 'pptp': $vpn_type='PPTP'; break;
 case 'l2tp': $vpn_type='L2TP'; break;
 case 'ovpn': $vpn_type='OpenVPN'; break;
 default: $vpn_type='Too many.';
}

$vpn = ",\n vpn: {\n ". $out[1]
."\n  type: '". $vpn_type ."',
  status: '". (($vpn_type=='-')?'-':'Connected') ."'\n },";

//if( (array_key_exists('do',$_REQUEST) && $_REQUEST['do']=='ip') || !file_exists("/var/www/stat/ip")){ exec("php get_remote_ip.php"); }

echo "info = {\n"
.$wan
.$proxy
.$vpn
. "\n ". implode("\n ",$out)
."\n}";

?>
