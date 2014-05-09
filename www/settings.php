<!DOCTYPE html>
<html><head><meta charset='UTF-8'>
<title>[Sabai Technology] Update</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.7.2.js'></script>
<script type='text/javascript' src='sabaivpn.php'></script>
<script type="text/javascript">

</script>

<body>
	<form id='_fom'>
		<input type='hidden' name='version' id='_version'>
		<table id='container' cellspacing=0>
			<tr id='body'>    
				<td id='navi'>
          <script type='text/javascript'>navi()</script>
        </td>

        <td id='content'>
					<div id='proxy' class=''>
						<div class='section-title'>Proxy</div>
						<div class='section'>
							Select Status:
							<select id='proxyStatus'>
								<option>On</option>
								<option>Off</option>
							</select>
							<br><br>
							Port: <input type='text' placeholder='1025-65535' name='portNum' id='portNum' class='shortinput'/><br><br>
							<input type='button' name='proxySet' id='proxySet' value='Set'/>
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
				</td>
			</tr>
		</table>
	</form>
</body>
</html>