<!DOCTYPE html><html><head><meta charset='UTF-8'><meta name='robots' content='noindex,nofollow'>
<title>[Sabai Technology] L2TP</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.7.2.js'></script>
<script type='text/javascript' src='sabaivpn.php'></script>
<script type='text/javascript'>
var hidden, hide, f,oldip='',limit=10,info=null,ini=false;

l2tp = {<?php
 $inf=trim(file_get_contents("/var/www/usr/l2tp"));
 if( $inf!=false ) $inf=explode(" ",$inf);
 if( count($inf)==4 ) echo "\n\tuser: '". $inf[0] ."',\n\tpass: '". $inf[1] ."',\n\tpsk: '". $inf[2]."',\n\tserver: '". $inf[3] ."'\n";
 else echo " user: '', pass: '', psk: '', server: '' ";
?>}

function setUpdate(res){
 if(info) oldip = info.vpn.ip;
 eval(res);
 if(oldip!='' && info.vpn.ip==oldip){ limit--; }
 if(limit<0) return;
 setVPNStats();
}
function getUpdate(){ que.drop('bin/info.php',setUpdate); }
function L2TPresp(res){ eval(res); msg(res.msg); showUi(); if(res.sabai){ limit=10; getUpdate(); } }
function L2TPsave(act){ hideUi("Adjusting L2TP..."); E("_act").value=act; que.drop("bin/l2tp.php",L2TPresp, $("#_fom").serialize()); }
function init(){ f = E('_fom'); hidden = E('hideme'); hide = E('hiddentext'); for(var i in l2tp){ E(i).value = l2tp[i]; }; getUpdate(); }

</script></head><body onload='init();' id='topmost'>
<table id='container' cellspacing=0>
<tr id='body'>		<td id='navi'>
					<script type='text/javascript'>navi()</script>
				</td><td id='content'>

<form id='_fom' method='post'>
<input type='hidden' id='_act' name='act'>

<div class='section-title'>L2TP</div><div class='section'>
<table class="fields"><tbody>
 <tr><td class="title indent1">Server</td><td class="content"><input name="server" id="server" class='longinput' type="text"></td></tr>
 <tr><td class="title indent1">Username</td><td class="content"><input name="user" id="user" class='longinput' type="text"></td></tr>
 <tr><td class="title indent1">Password</td><td class="content"><input name="pass" id="pass" class='longinput' autocomplete="off" onfocus='peekaboo("pass")' onblur='peekaboo("pass")' type="password"></td></tr>
 <tr><td class="title indent1">PSK</td><td class="content"><input name="psk" id="psk" class='longinput'  autocomplete="off" onfocus='peekaboo("psk")' onblur='peekaboo("psk")' type="password"></td></tr>
</tbody></table>
<input type='button' class= 'firstButton' value='Start' onclick='L2TPsave("start")'>
<input type='button' value='Stop' onclick='L2TPsave("stop")'>
<input type='button' value='Save' onclick='L2TPsave("save")'>
<input type='button' value='Cancel' onclick='javascript:reloadPage();'>
<input type='button' value='Help' onclick='window.open("http://www.sabaitechnology.com/v/sabaiHelp/vpnahelp.html#l2tp","_newtab");'>
<span id='messages'>&nbsp;</span><br>
</div></form>
</td></tr></table>

<div id='hideme'><div class='centercolumncontainer'><div class='middlecontainer'>
<div id='hiddentext'>Please wait...</div><br><center><img src='images/menuHeader.gif'></center>
</div></div></div>
</body></html>
