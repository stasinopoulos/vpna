<!DOCTYPE html><html><head><meta charset='UTF-8'><meta name='robots' content='noindex,nofollow'>
<title>[Sabai Technology] Logs</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.7.2.js'></script>
<script type='text/javascript' src='sabaivpn.php'></script>
<script type='text/javascript'>
var logWindow, logForm, logSelect, hidden, hide;
function setDropdown(res){ eval(res);
 while(i = logs.shift()){ $('#log').append(new Option(i,i)); }
// Which is faster?
// $.each(logs, function(key,value){ $('#log').append(new Option( value , value )); });
 logSelect.value="syslog";
}
function getDropdown(){ que.drop("bin/logs.php", setDropdown, 'act=list&log=&lines=&find='); }

function setLog(res){ showUi(); logWindow.value = res; }
function getLog(n){ hideUi("Fetching log..."); logForm.act.value=n; que.drop("bin/logs.php", setLog, $("#_fom").serialize() ); }

function catchEnter(event){ if(event.keyCode==13) getLog('find'); }

function init(){ hidden = E('hideme'); hide = E('hiddentext'); 
 logWindow = E('response');
 logForm = E('_fom');
 logSelect = E('log');
 getDropdown();
 $('#findText').on("keydown", catchEnter);
}
</script>

<style type='text/css'>
.tablemenu { width: 100%; border: 1px transparent double !important; border-collapse: collapse; }
.tablemenu td { border: 1px black solid; text-align: center; }
#log { width:200px; margin-left:5px; background:#FFF; }
#lines { background:#FFF; }
#findText { position: relative; top: -1px; }
#response { width: 100%; height: 480px; margin-top:2px; box-shadow: .3px .3px .3px .3px inset; background:#FFF; }
.pointy { cursor: pointer; }
</style>

</head>
<body onload='init();'>
<form id='_fom' method='post'>
<input type='hidden' name='act' value='all'>
<table id='container' cellspacing=0>
<tr><td colspan=2 id='header'><a href='http://www.sabaitechnology.com'><img src='images/sabai.png' id='headlogo'></a>
<div class='title' id='SVPNstatus'>Sabai VPN</div>
<div class='version' id='subversion'>Accelerator</div>
</td></tr>
<tr id='body'><td id='navi'><script type='text/javascript'>navi()</script></td>
<td id='content'>
<div id='ident'>Sabai Technology</div>
<div id='logging'>
<div class='section-title'>Logs</div>
<div class='section'>

<table class='tablemenu'><tbody><tr>
<td>
 <a onclick="getLog('last');" class="pointy">View Last </a>
 <input onclick='return;' type="text" name='lines' id='lines' size='5' value='25' />
 <a onclick="getLog('last');" class="pointy"> Lines</a>
</td>
<td><a onclick="getLog('all');" class="pointy">View All</a></td>
<td><select id='log' name='log' onchange="getLog('all');"></td>
<td><input type="text" maxsize=32 size=33 id='findText' name='find'><input type="button" value="Find" onclick="getLog('find');" id='finder'></td>
</tr></tbody></table>
<textarea id='response' style=""></textarea>

</div></div>
</td></tr>
</table></form>

<div id='hideme'><div class='centercolumncontainer'><div class='middlecontainer'>
<div id='hiddentext'>Please wait...</div><br><center><img src='images/SabaiSpin.gif'></center>
</div></div></div>

</body></html>

