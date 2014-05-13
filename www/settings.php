<!DOCTYPE html>
<html><head><meta charset='UTF-8'>
<title>[Sabai Technology] Update</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.7.2.js'></script>
<script type='text/javascript' src='sabaivpn.php'></script>
<script type="text/javascript">
var hidden, hide, settingsForm, settingsWindow, oldip='',limit=10,info=null,ini=false;

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

function Settingsresp(res){ 
	settingsWindow.innerHTML = res;
	eval(res); 
	msg(res.msg); 
	showUi(); 
	if(res.sabai){ 
		limit=10; 
		getUpdate(); 
	} 
}

function proxysave(act){ 
	hideUi("Adjusting Proxy..."); 
	settingsForm.act.value=act;  
	que.drop("bin/proxy.php",Settingsresp, $("#_fom").serialize() ); 
}


function system(act){ 
	hideUi("Processing Request..."); 
	settingsForm.act.value=act; 
	que.drop("bin/system.php",Settingsresp, $("#_fom").serialize() ); 
}

function init(){ 
	f = $('#_fom'); 
	hidden = E('hideme'); 
	hide = E('hiddentext'); 
	settingsForm = E('_fom');
	settingsWindow = E('response');
	getUpdate(); 
}

</script>

<body onload='init();' id='topmost'>
		<table id='container' cellspacing=0>
			<tr id='body'>    
				<td id='navi'>
          <script type='text/javascript'>navi()</script>
        </td>

        <td id='content'>
        	<form id='_fom' method='post'>
        	<input type='hidden' id='_act' name='act' value='reboot'>
					<div id='vpnstats'></div>
					<div id='proxy' class=''>
						<div class='section-title'>Proxy</div>
						<div class='section'>

							Port: <input type='text' placeholder='1025-65535' name='portNum' id='portNum' class='shortinput'/><br><br>
							<input type='button' value='Start' onclick='proxysave("start")'>
							<input type='button' value='Stop' onclick='proxysave("stop")'>

						</div>
					</div>
					<div id='dhcpLease' class=''>
						<div class='section-title'>DHCP Lease</div>
						<div class='section'>
							<input type='button' name='leaseReset' id='leaseReset' value='Reset' onclick='system("dhcp")'/>
						</div>
					</div>
					<div id='onOff' class=''>
						<div class='section-title'>Power</div>
						<div class='section'>
							<input type='button' name='power' id='power' value='Off' onclick='system("shutdown")'/>
							<input type='button' name='restart' id='restart' value='Restart' onclick='system("reboot")'/>
						</div>
					</div>
					<br>
					<span id='messages'>&nbsp;</span>
					<pre id='response'></pre>
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