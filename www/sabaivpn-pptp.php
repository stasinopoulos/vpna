<!DOCTYPE html><html><head><meta charset='UTF-8'><meta name='robots' content='noindex,nofollow'>
<title>[Sabai Technology] PPTP</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.7.2.js'></script>
<script type='text/javascript' src='sabaivpn.php'></script>
<script type='text/javascript'>
var hidden, hide, f,oldip='',limit=10,info=null,ini=false;

pptp = {<?php
 $inf=trim(file_get_contents("/var/www/usr/pptp"));
 if( $inf!=false ) $inf=explode(" ",$inf);
 if( count($inf)==3 ) echo "\n\tuser: '". $inf[0] ."',\n\tpass: '". $inf[1] ."',\n\tserver: '". $inf[2] ."'\n";
 else echo " user: '', pass: '', server: '' ";
?>}

function setUpdate(res){
 if(info) oldip = info.vpn.ip;
 eval(res);
 if(oldip!='' && info.vpn.ip==oldip){ limit--; }
 if(limit<0) return;
 setVPNStats();
}
function getUpdate(){ 
	que.drop('bin/info.php',setUpdate); 
}
function PPTPresp(res){ 
	eval(res); 
	msg(res.msg); 
	showUi(); 
	if(res.sabai){ 
		limit=10; 
		getUpdate(); 
	} 
}
function PPTPsave(act){ 
	hideUi("Adjusting PPTP..."); 
	E("_act").value=act; 
	que.drop("bin/pptp.php",PPTPresp, $("#_fom").serialize() ); 
}
function init(){ 
	f = E('_fom'); 
	hidden = E('hideme'); 
	hide = E('hiddentext'); 
	for(var i in pptp){ 
		E(i).value = pptp[i]; 
	}; 
	getUpdate(); 
}

</script>

</head>
<body onload='init();' id='topmost'>
	<table id='container' cellspacing=0>
		<tr id='body'>		
			<td id='navi'>
					<script type='text/javascript'>navi()</script>
			</td>
			<td id='content'>
				<div class="pageTitle">VPN: PPTP</div>
				<form id='_fom' method='post'>
				<input type='hidden' id='_act' name='act'>

				<div class='section-title'>PPTP Setup</div>
				<div class='section'>
					<table class="fields"><tbody>
					 <tr><td class="title indent1 shortWidth">Server</td><td class="content"><input name="server" id="server" class='longinput' type="text"></td></tr>
					 <tr><td class="title indent1 shortWidth">Username</td><td class="content"><input name="user" id="user" class='longinput' type="text"></td></tr>
					 <tr><td class="title indent1 shortWidth">Password</td><td class="content"><input name="pass" id="pass" class='longinput' autocomplete="off" onfocus='peekaboo("pass")' onblur='peekaboo("pass")' type="password"></td></tr>

					</tbody></table>
					<input type='button' class='firstButton' value='Start' onclick='PPTPsave("start")'>
					<input type='button' value='Stop' onclick='PPTPsave("stop")'>
					<input type='button' value='Save' onclick='PPTPsave("save")'>
					<input type='button' value='Cancel' onclick='javascript:reloadPage();'>
					<input type='button' value='Help' onclick='window.open("http://www.sabaitechnology.com/v/sabaiHelp/vpnahelp.html#pptp","_newtab");'>
					<span id='messages'>&nbsp;</span><br>
				</div>
				</form>
			</td>
		</tr>
	</table>

	<div id='hideme'>
		<div class='centercolumncontainer'>
			<div class='middlecontainer'>
				<div id='hiddentext'>Please wait...</div>
				<br>
				<center>
				<img src='images/menuHeader.gif'>
				</center>
			</div>
		</div>
	</div>
</body>
</html>
