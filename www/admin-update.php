<?php
 if(array_key_exists('version',$_REQUEST)){
  if($_REQUEST['version']!='new'){
   header("Content-type: text/ecmascript; charset=utf-8;");
   $req=array( 'version'=>$_REQUEST['version'], 'uid'=>exec("[ -e /sys/class/dmi/id/product_uuid ] && sudo cat /sys/class/dmi/id/product_uuid") );
#   $updURL='http://blog.sabaitechnology.com/grabs/vpnaupd.php';
#   $updURL='http://10.0.2.1:8080/grabs/vpnaupd.php';
   $updURL='http://192.168.222.197/grabs/vpnaupd.php';
   $pass='tihuovehe8482E31365';
   $iv='80408020E0301030';
   $rstr=urlencode(openssl_encrypt(serialize($req), 'aes128', $pass,false,$iv));
   $resp=unserialize( openssl_decrypt( file_get_contents($updURL .'?plz='. $rstr), 'aes128', $pass,false,$iv));
   if($resp['newversion']!=false){
    file_put_contents("bin/tmp.upgrade.sh",base64_decode($resp['upgrade']));
    chmod("bin/tmp.upgrade.sh", 0755);
   }
   echo "svm={ sabai: ". ($resp['newversion']!=false?'true':'false') .", msg: '". $resp['msg'] ."' }";
  }else{
   exec("sudo bin/tmp.upgrade.sh 2>&1",$out);
   unlink("bin/tmp.handler.sh");
   echo htmlentities(implode("\n",$out));
  }
  return;
 }
?><!DOCTYPE html>
<html><head><meta charset='UTF-8'>
<title>[VPN Accelerator] Update</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.11.1.min.js'></script>
<script type='text/javascript' src='sabaivpn.php'></script>
<script type='text/javascript'>
var hidden, hide;
var version='<?php readfile("sys/version"); ?>';

function updateFinish(text){ hidden.style.display='none'; E('_doUpdate').className='hiddenChildMenu'; E('messages').innerHTML=text; }
function doUpdate(){ E('_version').value='new'; hideUi("Updating..."); que.drop("admin-update.php",updateFinish, $("#_fom").serialize()); }
function updateResponse(text){ // hidden.style.display='none'; E('messages').innerHTML=text; return;
 eval(text); hidden.style.display='none';
 if(svm.msg!='') E('messages').innerHTML = svm.msg;
 if(svm.sabai){ E('_checkUpdate').className='hiddenChildMenu'; E('_doUpdate').className=''; }
}

function checkUpdate(){ hideUi("Checking for update..."); que.drop("admin-update.php",updateResponse, $("#_fom").serialize()); }

function init(){
 E('_version').value = (version==''?'000':version);
 E('cversion').innerHTML= version.substr(0,1) +'.'+ version.substr(1);
 hidden = E('hideme'); hide = E('hiddentext');
  $('.active').removeClass('active')
$('#update').addClass('active')
}// </script></head>
<body onload='init()'><form id='_fom'><input type='hidden' name='version' id='_version'><table id='container' cellspacing=0>
<tr id='body'>    <td id='navi'>

<!--           <a href='http://www.sabaitechnology.com'>
            <img src='images/menuHeader.gif' id='headlogo'>
          </a> -->
          <script type='text/javascript'>navi()</script>
        </td><td id='content'>

<div id='update' class=''>
  <div class="pageTitle">Update</div>
	<div class='section-title'>Sabai VPNA Update</div>
	<div class='section'>
		<div>Current Version: <span id='cversion'></span></div><br>
		<div id='newversion' class='hiddenChildMenu'>New Version: <span id='available'></span></div><br>
		<input type='button' value='Check for Update' id='_checkUpdate' onclick='checkUpdate();'>
		<input type='button' class='hiddenChildMenu' id='_doUpdate' value='Run Update' onclick='doUpdate();'>
	</div>
</div>
<br>
<pre id='messages'></pre>
</td></tr></table>

<div id='hideme'><div class='centercolumncontainer'><div class='middlecontainer'>
 <div id='hiddentext'>Please wait...</div><br>
 <center><img src='images/menuHeader.gif'></center>
</div></div></div>

</form></body></html>
