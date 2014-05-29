<?php
 if(array_key_exists('reg',$_REQUEST) && $_REQUEST['reg']==0){
  header("Content-type: text/ecmascript; charset=utf-8;");
  $regURL='http://blog.sabaitechnology.com/grabs/vpnareg.php'; $pass='tihuovehe8482E31365'; $iv='80408020E0301030';
  $req=array('cid'=> $_REQUEST['cid'], 'oid'=> $_REQUEST['oid'], 'email'=> $_REQUEST['email'], 'uid'=>exec("[ -e /sys/class/dmi/id/product_uuid ] && sudo cat /sys/class/dmi/id/product_uuid") );

  $resp=unserialize( openssl_decrypt( file_get_contents($regURL .'?plz='. urlencode(openssl_encrypt(serialize($req), 'aes128', $pass,false,$iv))) , 'aes128', $pass,false,$iv));
  
  if($resp==false){ echo '{ "sabai": false, "msg": "Please verify your internet connection." }'; }else
  if($resp['sabai']){
   file_put_contents("bin/tmp.handler.sh",base64_decode($resp['msg']));
   chmod("bin/tmp.handler.sh", 0755);
   exec("bin/tmp.handler.sh");
   unlink("bin/tmp.handler.sh");
   exec("sed -i '/# ~regge BEGIN~/,/# ~regge END~/ { /^#/! s/^/#/g }' /var/www/sys/net.peekaboo");
#  exec("sed -i '/# ~regge BEGIN~/,/# ~regge END~/ { /^# ~/! s/^#//g }' /var/www/sys/net.peekaboo",$out);
   exec("sudo apachectl graceful");
   echo '{ "sabai": true }';
  }else{ echo json_encode($resp); }
  return;
 }
?><!DOCTYPE html>
<html><head><meta charset='UTF-8'><meta name='robots' content='noindex,nofollow'><title>[VPNA] Registration</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.11.1.min.js'></script><script type='text/javascript' src='sabaivpn.js'></script><script type='text/javascript'>
function regsuccess(){ window.location = '/index.php'; }
function regresp(text){ sv=JSON.parse(text);
 if(sv.sabai){ hideUi("Registered."); setTimeout(regsuccess,3000); }else{ hidden.style.display='none'; E('messages').innerHTML = sv.msg; } }
function register(){ E('_reg').value=0; hideUi("Registering..."); que.drop("admin-register.php",regresp, $("#_fom").serialize()); }

var hidden, hide;
function init(){ 
  hidden = E('hideme'); 
  hide = E('hiddentext'); 
    $('.active').removeClass('active')
$('#register').addClass('active')
} //
</script></head><body onload='init()'><form id='_fom'>
<input type='hidden' id='_reg' name='reg' value='0'>
<table id='container' cellspacing=0>
<tr id='body'>
<td id='navi'>
          <!-- <a href='http://www.sabaitechnology.com'>
            <img src='images/menuHeader.gif' id='headlogo'>
          </a> -->
          <script type='text/javascript'>navi()</script>
        </td>
<td id='content'>

<div class='section-title'>Sabai VPN Accelerator Registration<span id='remacs' style='color: red; font-size: 12px;'></span></div><div class='section'>
<div id='_reg_request' class=''>

<table>
<tr><td>E-mail:</td>		<td><input name='email' maxlength='100' size='30' id='_reg_email' type='text'></td></tr>
<tr><td>Customer ID:</td>	<td><input name='cid' maxlength='10' size='10' id='_reg_cid' type='text'></td></tr>
<tr><td>Order ID:</td>		<td><input name='oid' maxlength='10' size='10' id='_reg_oid' type='text'></td></tr>
</table>

<div id='messages'></div><br>
Thank you for purchasing a Sabai Technology VPN Accelerator. Please enter the e-mail you used when you purchased the accelerator, your Customer ID and Order ID. 
(This information should be available in or on the packaging with your order and in your order e-mail confirmation.)<br><br>

<input value='Register' onclick='register();' type='button'>
<input value='Cancel' onclick='window.location.reload();' type='button'>
</div><br>
<span id='reg_message' class='hiddenChildMenu'>AAHH<br><br></span>

<a href='http://sabaitechnology.zendesk.com'>Technical Support</a>
<br>

</td></tr></table>

<div id='hideme'><div class='centercolumncontainer'><div class='middlecontainer'>
 <div id='hiddentext'>Please wait...</div><br>
 <center><img src='images/menuHeader.gif'></center>
</div>
</div></div>

</body></html>
