<?php
$proxystatus = file_get_contents('/var/www/stat/proxy.connected');
?>
<?php
$proxyport = file_get_contents('/var/www/stat/proxy.port');
 ?>
<!DOCTYPE html>
<html><head><meta charset='UTF-8'>
<title>[Sabai Technology] Settings</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.11.1.min.js'></script>
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
	<?php $proxystatus = file_get_contents('/var/www/stat/proxy.connected'); ?>
	<?php $proxyport = file_get_contents('/var/www/stat/proxy.port'); ?>
	setTimeout("window.location.reload()",1000);
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
	$('.active').removeClass('active')
	$('#settings').addClass('active')
}

</script>

<body onload='init();' id='topmost'>
		<table id='container' cellspacing=0>
			<tr id='body'>    
				<td id='navi'>
          <script type='text/javascript'>navi()</script>
        </td>

        <td id='content'>
        	<div class="pageTitle">Settings</div>
        	<form id='_fom' method='post'>
        	<input type='hidden' id='_act' name='act' value='reboot'>
					<div id='vpnstats'></div>
					<div id='proxy' class=''>
						<div class='section-title'>Proxy</div>
						<div class='section'>
							<table>
								<tr>
									<td>Proxy Status: <?php echo $proxystatus; ?></td>
								</tr>
								<tr>
									<td>Current Port: <?php echo $proxyport; ?></td>
								</tr>
							</table>
							<br>
							<p>Port: <input type='text' value='<?php echo $proxyport; ?>' name='portNum' id='portNum' class='shortinput'/></p>
							<input type='button' id='proxyStart' value='Start' onclick='proxysave("start")'>
							<input type='button' id='proxyStop' value='Stop' onclick='proxysave("stop")'>
							<input type='button' id='proxySave' value='Save' onclick='proxysave("save")'>
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
					<div class='section-title'>Username</div>
						<div class='section'>
							<table>
								<tr>
									<td>Username:</td>
									<td><input type='text' id='vpnaUsername'></td>
								</tr>
								<tr>
									<td>Password:</td>
									<td><input type='password' id='vpnaPassword'></td>
								</tr>
								<tr>
									<td>Confirm Password:</td>
									<td><input type='password' id='vpnaPWConfirm'></td>
								</tr>
							</table>
							<br>
							<button id='usernameUpdate'>Update</button>
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
