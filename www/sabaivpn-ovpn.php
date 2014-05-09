<!DOCTYPE html>
<html>

<head>
	<meta charset='UTF-8'>
	<meta name='robots' content='noindex,nofollow'>
	<title>[Sabai Technology] OpenVPN</title>
	
	<link rel='stylesheet' type='text/css' href='sabai.css'>
	
	<script type='text/javascript' src='jquery-1.7.2.js'></script>
	<script type='text/javascript' src='sabaivpn.php'></script>
	<style type='text/css'>

	</style>
	<script type='text/javascript'>

		var hidden,hide,f,oldip='',limit=10,logon=false,info=null;

		ovpn=<?php if(!readfile("/var/www/usr/ovpn")) echo 'false'; ?>;

		function setLog(res){ 
			E('log').value = res; 
		}

		function saveEdit(){ 
			hideUi("Adjusting OpenVPN..."); 
			E("_act").value='save'; 
			que.drop( "bin/ovpn.php", OVPNresp, $("#_fom").serialize() ); 
		}

		function toggleEdit(){
		 E('ovpn_controls').style.display='none';
		 E('logButton').style.display='none';
		 E('edit').className='';
		 E('editButton').style.display='none';
		 var conf=E('conf');
		 var leng=(conf.value.match(/\n/g)||'').length;
		 conf.style.height=(leng<15?'15':leng)+'em';
		}

		function toggleLog(){
		 if(logon=!logon){ 
		 	que.drop('bin/ovpn.php', setLog, 'act=log'); 
		 }
		 E('logButton').value = (logon?'Hide':'Show') + " Log";
		 E('log').className = (logon?'':'hiddenChildMenu');
		}

		function load(){
		 var y=( ovpn && ovpn.file != null && ovpn.file != '');
		 E('ovpn_controls').style.display = (y?'':'none');
		 E('upload').style.display = (y?'none':'');
		 E('ovpn_file').innerHTML = 'Current File: ' + (y?ovpn.file:'');
		 msg(y?'':'You may supply a .conf/.ovpn complete configuration or a DD-WRT style .sh script.');
		}

		function setUpdate(res){ 
			if(info) oldip = info.vpn.ip; 
			eval(res); 
			if(oldip!='' && info.vpn.ip==oldip){ 
				limit--; 
			}; 
			if(limit<0) return; setVPNStats(); 
		}

		function getUpdate(){ 
			que.drop('bin/info.php',setUpdate,'what=ovpn'); 
		}

		function OVPNresp(res){ 
			eval(res); 
			msg(res.msg); 
			showUi(); 
			if(res.reload){ 
				window.location.reload(); 
			}; 
			if(res.sabai){ 
				limit=10; getUpdate(); 
			} 
		}

		function OVPNsave(act){ 
			hideUi("Adjusting OpenVPN..."); 
			E("_act").value=act; 
			que.drop( "bin/ovpn.php", OVPNresp, $("#_fom").serialize() ); 
		}

		function init(){ 
			f = E('_fom'); 
			hidden = E('hideme'); 
			hide = E('hiddentext'); 
			load(); 
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

				<div class='section-title'>OpenVPN Setup</div>
				<div class='section'>
				
					<form id='newfile' method='post' action='bin/ovpn.php' encType='multipart/form-data'>
						<input type='hidden' name='act' value='newfile'>
						<span id='ovpn_file'></span>
						<span id='upload'>
						<input type='file' id='file' name='file'>
						<input type='button' value='Upload' onclick='submit()'></span>
						<br>
						<span id='messages'></span>
					</form>

					<form id='_fom'>
						<span id='ovpn_controls'>
						<input type='hidden' id='_act' name='act' value=''>
						<input type='button' value='Start' onclick='OVPNsave("start");'>
						<input type='button' value='Stop' onclick='OVPNsave("stop");'>
						<input type='button' value='Reset' onclick='OVPNsave("erase");'></span>
						<input type='button' class = 'firstButton' value='Show Log' id='logButton' onclick='toggleLog();'>
						<input type='button' value='Edit' id='editButton' onclick='toggleEdit();'>
						<input type='button' value='Help' onclick='window.open("http://www.sabaitechnology.com/v/sabaiHelp/vpnahelp.html#ovpn","_newtab");'>
						<span id='messages'>&nbsp;</span><br>
						</div> <!-- what does this close? if it closes the section div, why is it here?-->

						<textarea id='log' class='hiddenChildMenu'></textarea>
						<div id='edit' class='hiddenChildMenu'>
						 Name:
						 <input type='text' name='VPNname' id='VPNname' placeholder='(optional)'>
						 Password: 
						 <input type='text' name='VPNpassword' id='VPNpassword' placeholder='(optional)'>

						 <textarea id='conf' name='conf'>
						 	<?php readfile('/var/www/usr/ovpn.current'); ?>
						 </textarea> <br>
						 <input type='button' value='Save' onclick='saveEdit();'>
						 <input type='button' value='Cancel' onclick='window.location.reload();'>
						</div>
					</form>
			</td>
		</tr>
	</table>
	<div id='hideme'>
		<div class='centercolumncontainer'>
			<div class='middlecontainer'>
				<div id='hiddentext'>Please wait...</div>
				<br><center><img src='images/menuHeader.gif'></center>
			</div>
		</div>
	</div>
</body>
</html>
