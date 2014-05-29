<html>
<head>
	<meta charset='UTF-8'><meta name='robots' content='noindex,nofollow'>
	<title>[Sabai Technology] SSH</title>
	<link rel='stylesheet' type='text/css' href='sabai.css'>
	<script type='text/javascript' src='jquery-1.11.1.min.js'></script>
	<script type='text/javascript' src='sabaivpn.js'></script>
	<script type='text/javascript'>

		function SSH(act){
			hideUi("Adjusting SSH..."); 
			$('#_act').val(act);
			que.drop("bin/ssh.php",SSHresp, $("#_fom").serialize() ); 
		}

		function SSHresp(res){ 
			eval(res); 
			msg(res.msg); 
			showUi(); 
		}

		function init(){ 
			f = E('_fom'); 
			hidden = E('hideme'); 
			hide = E('hiddentext'); 
		}

	</script>
</head>
<body>
	<table id='container' cellspacing=0>
		<tr id='body'>		
			<td id='navi'>
					<script type='text/javascript'>navi()</script>
			</td>
			<td id='content'>
				<form id='_fom' method='post'>
					<div id='vpnstats' class='fright'></div>
					<div class="pageTitle">SSH Control</div>
					<input type='hidden' id='_act' name='act'>
					<div class='section-title'>SSH</div>
					<div class='section'>
						<input type='button' class='firstButton' value='On' onclick='SSH("on")'>
						<input type='button' value='Off' onclick='SSH("off")'>
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