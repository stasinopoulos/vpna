<!DOCTYPE html><html><head><meta charset='UTF-8'><meta name='robots' content='noindex,nofollow'>
<title>[Sabai Technology] Tools: <?php $tool=ucfirst($_REQUEST['tool']); echo $tool; ?></title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.7.2.js'></script>
<script type='text/javascript' src='sabaivpn.php'></script>
<script type='text/javascript'>
var logWindow, logForm, logSelect, hidden, hide;
function setLog(res){ showUi(); logWindow.innerHTML = res; }
function getLog(n){ hideUi("Executing..."); logForm.act.value=n; que.drop("bin/shell.php", setLog, $("#_fom").serialize() ); }
function init(){ hidden = E('hideme'); hide = E('hiddentext'); logWindow = E('response'); logForm = E('_fom'); logSelect = E('log'); }
</script><style type='text/css'>
.tablemenu { width: 100%; border: 1px transparent double !important; border-collapse: collapse; }
.tablemenu td { border: 1px black solid; font-family: Tahoma,Arial,sans-serif; }
#log { width:200px; margin-left:5px; background:#FFF; }
.lines { background:#FFF; }
#dobutton { position: relative; top: 0px; height: 22px; }
#response { width: 99%; max-width: 800px; min-height: 480px; margin-top: 4px; box-shadow: .3px .3px .3px .3px inset; background:#FFF; padding: 4px; overflow: auto; }
.pointy { cursor: pointer; }
#shellbox { font: 12px monospace; height: 12em; width: 99%; }
</style></head><body onload='init();'><form id='_fom' method='post'>
<input type='hidden' name='act' value='all'>
<table id='container' cellspacing=0>
<tr><td colspan=2 id='header'><a href='http://www.sabaitechnology.com'><img src='images/sabai.png' id='headlogo'></a><div class='title' id='SVPNstatus'>Sabai VPN</div><div class='version' id='subversion'>Accelerator</div></td></tr>
<tr id='body'><td id='navi'><script type='text/javascript'>navi()</script></td>
<td id='content'>
<div id='ident'>Sabai Technology</div>
<div id='logging'>
<div class='section-title'><?php echo $tool ?></div>
<div class='section'>
<table class='tablemenu'><tbody><tr><td><?php
switch($tool){
 case "Ping":{ echo "<input type='button' value='Ping' onclick='getLog(1);' id='dobutton'> <input type='text' name='ip' class='lines' size='16' value='localhost'/> <input type='text' name='count' class='lines' size='5' value='4'/> times with packet size: <input type='text' name='size' class='lines' size='5' value='56'/>"; break; }
 case "Trace":{ echo "<input type='button' value='Trace' onclick='getLog(2);' id='dobutton'> <input type='text' name='ip' class='lines' size='16' value='localhost'/> with at most <input type='text' name='count' class='lines' size='5' value='30'/> hops of max time <input type='text' name='size' class='lines' size='5' value='5.0'/> seconds."; break; }
 case "Route":{ echo "<input type='button' value='Route' onclick='getLog(3);' id='dobutton'>"; break; }
 case "Shell":{ echo "<textarea id='shellbox' name='cmd'></textarea><br><input type='button' value='Execute' onclick='getLog(4);' id='dobutton'>";
 break; }
}
?></td></tr></tbody></table>
<pre id='response'></pre>
</div></div></td></tr>
</table></form>

<div id='hideme'><div class='centercolumncontainer'><div class='middlecontainer'>
<div id='hiddentext'>Please wait...</div><br><center><img src='images/SabaiSpin.gif'></center>
</div></div></div>

</body></html>

