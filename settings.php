<!DOCTYPE html>
<html><head><meta charset='UTF-8'>
<title>[Sabai Technology] Update</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.7.2.js'></script>
<script type='text/javascript' src='sabaivpn.php'></script>
<script type="text/javascript">

function Proxyresp(res){ 
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
	E("_act").value=act; 
	que.drop("bin/proxy.php",Proxyresp, $("#_fom").serialize() ); 
}
</script>

<body>
		<input type='hidden' name='version' id='_version'>
		<table id='container' cellspacing=0>
			<tr id='body'>    
				<td id='navi'>
          <script type='text/javascript'>navi()</script>
        </td>

        <td id='content'>
        	<form id='_fom' method='post'>
					<input type='hidden' id='_act' name='act'>
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
							<input type='button' name='leaseReset' id='leaseReset' value='Reset'/>
						</div>
					</div>
					<div id='onOff' class=''>
						<div class='section-title'>Power</div>
						<div class='section'>
							<input type='button' name='power' id='power' value='Off'/>
							<input type='button' name='restart' id='restart' value='Restart'/>
						</div>
					</div>
					<br>
					<pre id='messages'></pre>
				</form>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>