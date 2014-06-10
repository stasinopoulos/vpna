<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<meta name='robots' content='noindex,nofollow'>
	<title>[VPNA] Logs</title>
	<link rel='stylesheet' type='text/css' href='sabai.css'>
	<script type='text/javascript' src='jquery-1.11.1.min.js'></script>
	<script type='text/javascript' src='sabaivpn.js'></script>
	<script type='text/javascript'>

	var logWindow, logForm, logSelect, hidden, hide;
	
	function setDropdown(res){ 
		eval(res);
	 	while(i = logs.shift()){ 
	 		$('#logSelect').append(new Option(i,i)); 
	 	}
		// Which is faster?
		// $.each(logs, function(key,value){ $('#log').append(new Option( value , value )); });
	 logSelect.value="syslog";
	}

	function getDropdown(){ 
		que.drop("bin/logs.php", setDropdown, 'act=list&log=&lines=&find='); 
	}

	function setLog(res){ 
		showUi(); 
		logWindow.value = res; 
		console.log("value of log is:" + res)
	}
	
	function getLog(n){ 
		hideUi("Fetching log..."); 
		logForm.act.value=n; 
		que.drop("bin/logs.php", setLog, $("#_fom").serialize() ); 
	}

	function catchEnter(event){ 
		if(event.keyCode==13) getLog('find'); 
	}

	function init(){ 
		hidden = E('hideme'); 
		hide = E('hiddentext'); 
		logWindow = E('response');
		logForm = E('_fom');
		logSelect = E('logSelect');
		getDropdown();
		$('#findText').on("keydown", catchEnter);
		$('.active').removeClass('active')
		$('#log').addClass('active')
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
					<div class="pageTitle">Logs</div>
					<div id='logging'>
						<div class='section-title'>View Logs</div>
						<div class='section'>

							<select id='logSelect' name='logSelect' class='fleft' onchange="getLog('all');"></select>
						 <a onclick="getLog('last');" class="pointy"> View Last </a>
						 <input onclick='return;' type="text" name='lines' id='lines' class='extrashortinput lines' value='25' />
						 <a onclick="getLog('last');" class="pointy">Lines</a> |
							<a onclick="getLog('all');" class="pointy">View All</a>
							
							<input type="button" value="Find" class='fright' onclick="getLog('find');" id='finder'>
							<input type="text" class='shortinput fright lines' id='findText' name='find'>
		
								
							<textarea id='response' class='tall' readonly=""></textarea>

						</div> <!-- end section -->
					</div> <!-- end logging -->
				</td>
			</tr>
		</table>
	</form>
<div id='footer'> Copyright © 2014 Sabai Technology, LLC </div>
	<div id='hideme'>
		<div class='centercolumncontainer'>
			<div class='middlecontainer'>
				<div id='hiddentext'>Please wait...</div>
				<br>
				<center><img src='images/menuHeader.gif'></center>
			</div>
		</div>
	</div>

</body>
</html>

