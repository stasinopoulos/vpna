<!DOCTYPE html><html><head><meta charset='UTF-8'><meta name='robots' content='noindex,nofollow'>
<title>[VPNA] Tools: <?php $tool=ucfirst($_REQUEST['tool']); echo $tool; ?></title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.11.1.min.js'></script>
<script type='text/javascript' src='sabaivpn.js'></script>
<script type='text/javascript'>
	var logWindow, logForm, logSelect, hidden, hide;
	function setLog(res){ 
		showUi(); 
		logWindow.innerHTML = res; 
	}
	
	function getLog(n){ 
		hideUi("Executing..."); 
		logForm.act.value=n; 
		que.drop("bin/shell.php", setLog, $("#_fom").serialize() ); 
	}
	function init(){ 
		hidden = E('hideme'); 
		hide = E('hiddentext'); 
		logWindow = E('response'); 
		logForm = E('_fom'); 
		logSelect = E('logSelect'); 
		$('#Diagnosticssub-menu').show();
		$('.active').removeClass('active')
		var whatPage = $('#whatPage').html()
		$('#'+whatPage).addClass('active')
		console.log(whatPage)
		if (whatPage == 'route') {
			getLog(3);
		}
	}


</script>

</head>

<body onload='init();'>
<form id='_fom' method='post'>
	<input type='hidden' name='act' value='all'>
		<table id='container' cellspacing=0>
			<tr id='body'>
				<td id='navi'>
				<script type='text/javascript'>navi()</script>
			</td>
			<td id='content'>
				<div class="pageTitle">Diagnostics: <?php echo $tool?></div>
				<div id='logging'>
					<div class='section-title'><?php echo $tool ?></div>
					<div class='section'>
						<table class='tablemenu'>
						<tbody>
							<tr>
								<td><?php
									switch($tool){
									 case "Ping":{ echo "<table class='fields'><tbody><tr><td class='title shortWidth'>Address</td><td><input type='text' name='ip' class='lines shortinput' value='localhost'/><input type='button' value='Ping' onclick='getLog(1);'></td></tr><tr><td>Ping Count</td><td><input type='text' name='count' class='lines extrashortinput' value='4'/</td></tbody></table><div id='whatPage' class='noshow'>ping</div>"; break; }
									 case "Trace":{ echo "<table class='fields'><tbody><tr><td class='title shortWidth'>Address</td><td><input type='text' name='ip' class='lines shortinput' value='localhost'/><input type='button' value='Trace' onclick='getLog(2);'></td></tr><tr><td>Hops</td><td><input type='text' name='count' class='lines extrashortinput' value='30'/></td></tr><tr><td>Max Time</td><td><input type='text' name='size' class='lines extrashortinput' value='5'/><span class='xsmallText'>(seconds)</span></td></tr></tbody></table><div id='whatPage' class='noshow'>trace</div>"; break; }
									 case "Route":{ echo "<input type='button' value='Refresh' onclick='getLog(3);'><div id='whatPage' class='noshow'>route</div>"; break; }
									 case "Shell":{ echo "<textarea id='shellbox' name='cmd'></textarea><br><input type='button' value='Execute' onclick='getLog(4);'><div id='whatPage' class='noshow'>shell</div>";
									 break; }
									}
									?>
								</td>
							</tr>
						</tbody>
						</table>
						<br>
						<pre id='response'></pre>
					</div>
				</div>
			</td>
		</tr>
	</table>
	<div id='footer'> Copyright © 2014 Sabai Technology, LLC </div>
</form>

<div id='hideme'><div class='centercolumncontainer'><div class='middlecontainer'>
<div id='hiddentext'>Please wait...</div><br><center><img src='images/menuHeader.gif'></center>
</div></div></div>

</body></html>

