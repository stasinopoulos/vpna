<?php if(!file_exists('bin/info.php')) header('Location: admin-register.php'); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'><meta name='robots' content='noindex,nofollow'>
	<title>[Sabai Technology] Status</title>
	<link rel='stylesheet' type='text/css' href='sabai.css'>
	<script type='text/javascript' src='jquery-1.7.2.js'></script>
	<script type='text/javascript' src='sabaivpn.php'></script>
	<script type='text/javascript'>

		function setUpdate(res){ 
			eval(res);
		 	for(i in info.wan){ 
		 		E('wan'+i).innerHTML = info.wan[i]; 
		 	}
                        for(i in info.proxy){ 
                                E('proxy'+i).innerHTML = info.proxy[i]; 
                        }
		 	
		 	for(i in info.vpn){ 
		 		E('vpn'+i).innerHTML = info.vpn[i]; 
		 	}
		 	
		 	for(i in info.donde){ 
		 		E('loc'+i).innerHTML = info.donde[i]; 
		 	}
		 	
		 	E('refbutton').disabled = false;
		}


		function getUpdate(ipref){ 
			E('refbutton').disabled = true; 
			que.drop('bin/info.php',setUpdate,ipref?'do=ip':null); 
		}

		function init(){ getUpdate(); $('#status').addClass('active')
	}
	</script>
</head>
<body onload='init()'>
	<form>
		<table id='container' cellspacing=0>
<!-- 			<tr>
				<td colspan=2 id='header'>
					<a href='http://www.sabaitechnology.com'>
						<img src='images/menuHeader.gif' id='headlogo'>
					</a>
 					<div class='title' id='SVPNstatus'>Sabai</div>
					<div class='version' id='subversion'>Accelerator</div>
				</td>
			</tr> -->
			<tr id='body'>
				<td id='navi'>
					<script type='text/javascript'>navi()</script>
				</td>
				<td id='content'>
					<div class="pageTitle">Status</div>
					<div class='section-title'>WAN</div>
					<div class='section' id='wan-section'>
						<table class="fields">
							<tbody>
								<tr>
									<td class="title indent1">MAC Address</td>
									<td class="content" id='wanmac'></td>
								</tr>
								<tr>
									<td class="title indent1">IP Address</td>
									<td class="content" id='wanip'></td>
								</tr>
								<tr>
									<td class="title indent1">Status</td>
									<td class="content" id='wanstatus'></td>
								</tr>

							</tbody>
						</table>
					</div>

                                        </div>

                                        <div class='section-title'>Proxy</div>
                                        <div class='section' id='sabaiproxy-section'>
                                                <table class="fields">
                                                        <tbody>
                                                                <tr>
                                                                        <td class="title indent1">Port Number</td>
                                                                        <td class="content" id='proxyport'></td>
                                                                </tr>
                                                                <tr>
                                                                        <td class="title indent1">Status</td>
                                                                        <td class="content" id='proxystatus'></td>
                                                                </tr>
                                                        </tbody>
                                                </table>
                                        </div>

					<div class='section-title'>VPN</div>
					<div class='section' id='sabaivpn-section'>
						<table class="fields">
							<tbody>
								<tr>
									<td class="title indent1">Connection Type</td>
									<td class="content" id='vpntype'></td>
								</tr>
								<tr>
									<td class="title indent1">Status</td>
									<td class="content" id='vpnstatus'></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class='section-title'>Location</div>
					<div class='section' id='sabaivpn-section'>
						<table class="fields">
							<tbody>
							<tr>
								<td class="title indent1">IP Address</td>
								<td class="content" id='locip'></td>
							</tr>
							<tr>
								<td class="title indent1">Continent</td>
								<td class="content" id='loccontinent'></td>
							<tr>
								<td class="title indent1">Country</td>
								<td class="content" id='loccountry'></td>
							</tr>
							<tr>
								<td class="title indent1">Region</td>
								<td class="content" id='locregion'></td>
							<tr>
								<td class="title indent1">City</td>
								<td class="content" id='loccity'></td>
							</tr>
							</tbody>
						</table>
					</div>

					<input id='refbutton' type='button' value='Refresh' onclick='getUpdate(1);' style='float: right; margin-right: 50px;'>

				</td> <!-- end content -->
			</tr> <!-- end body -->
		</form>
	</table>
</body>
</html>
