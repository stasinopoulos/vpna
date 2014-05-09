<!DOCTYPE html><html><head><meta charset='UTF-8'><meta name='robots' content='noindex,nofollow'>
<title>[Sabai Technology] About</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.7.2.js'></script>
<script type='text/javascript' src='sabaivpn.php'></script>
<script type='text/javascript'>

vpna = {
 dist: '<?php echo (file_exists("/etc/lsb-release")?str_replace("Ubuntu","Ubuntu Server",exec("sudo grep 'DISTRIB_DESCRIPTION' /etc/lsb-release | cut -d '=' -f2 | tr -d '\"'")):"Ubuntu Server") ?>',
 kern: '<?php echo exec("uname -r -m"); ?>',
 vers: '<?php echo substr_replace(file_get_contents("sys/version"),'.',1,0); ?>'
}

function init(){
 if(vpna==null || vpna==undefined) return;
 if(vpna.dist!=null&&vpna.dist!=undefined&&vpna.dist!='') E('distro').innerHTML = vpna.dist;
 if(vpna.kern!=null&&vpna.kern!=undefined&&vpna.kern!='') E('kernel').innerHTML = vpna.kern;
 if(vpna.vers!=null&&vpna.vers!=undefined&&vpna.vers!='') E('version').innerHTML = vpna.vers;
} //</script></head><body onload='init()'>
<table id='container' cellspacing=0>
<tr id='body'><td id='navi'>
					<script type='text/javascript'>navi()</script>
				</td>
<td id='content'>
<div id='ident'>Sabai Technology</div><div style='margin:20px 20px;font-size:14px;color:#555;'>

Sabai VPN Accelerator v<span id='version'>0.01</span> on <span id='distro'>Ubuntu Server</span> (<span id='kernel'></span>)

<p>Thank you for being a Sabai Technology customer!
<blockquote>Sabai Technology: <i>Technology for the People</i><br>
301 N Main Street<br>
Simpsonville, SC 29681<br>
+1-864-962-4072<br>
<A HREF='mailto:info@sabaitechnology.com'>info@sabaitechnology.com</a><br>
</blockquote>

<p>VPN GUI and API<br>
Copyright &copy; 2012 Sabai Technology, LLC<br>
<a href='http://www.sabaitechnology.com'>http://www.sabaitechnology.com</a><br>
VPN Client Interface - Sabai Technology US patent pending #13/292,509.

<p>We support and appreciate the exceptional work done by many in the development of Ubuntu Server and Linux opensource software.
 Ubuntu linux and licenses used can be found at <a href='http://www.ubuntu.com'>http://www.ubuntu.com</a>.

</div>
</td></tr>
</table>
</body>
</html>

