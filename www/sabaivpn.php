<?php header('Content-Type: text/ecmascript; charset=UTF-8'); ?>


Array.prototype.find = function(v){ var i = f.length; while(this[--i]!=v && i>=0); return i; }
Array.prototype.remove = function(v){ var i = this.find(v); if(i!=-1){ this.splice(i, 1); return true; }else{ return false; } }

function E(e){ return (typeof(e) == 'string') ? document.getElementById(e) : e; }
function peekaboo(id){ var e = E(id); e.type = e.type=='password' ? 'text' : 'password'; }
function reloadPage(){ document.location.reload(1); }

var cookie = {
 set: function(key, value, days){ document.cookie = 'vpna_' + key + '=' + value + '; expires=' + (new Date(new Date().getTime() + ((days ? days : 14) * 86400000))).toUTCString() + '; path=/'; },
 get: function(key){ var r = ('; ' + document.cookie + ';').match('; vpna_' + key + '=(.*?);'); return r ? r[1] : null; },
 unset: function(key) { document.cookie = 'vpna_' + key + '=; expires=' + (new Date(1)).toUTCString() + '; path=/'; }
};
function myName(){ var name, tool, i;
	name = document.location.href.replace(/\\/g, '/').split("?");
	tool = ( name.length > 1 ? '?'+name[1]:'');
	name = name[0];
	if ((i = name.lastIndexOf('/')) != -1) name = name.substring(i + 1, name.length);
	if (name == '') name = 'status-overview.php';
	return name+tool;
}

function toggleChildMenu(){ 
  var ch = E('sub-'+this.id); 
  ch.className = (ch.className == 'shownChildMenu') ? 'hiddenChildMenu' : 'shownChildMenu'; 
}

function navi(){ 
  var menu = [
    ['Status', '/'],
    ['VPN',	'sabaivpn', 0, 
      [
      	['PPTP',	'sabaivpn-pptp.php'],
      	['L2TP',	'sabaivpn-l2tp.php'],
      	['OpenVPN',	'sabaivpn-ovpn.php']
      ] 
    ],
    ['Settings', 'settings.php'],
    ['Logs',		'log.php'],
    ['Diagnostics', 'tools', 0, 
      [
      	['Ping',	'tools.php?tool=ping'],
      	['Trace',	'tools.php?tool=trace'],
      	['Route',	'tools.php?tool=route'],
      	['System',	'tools.php?tool=shell'] 
      ] 
    ],
    ['About',		'admin-about.php'],
    ['Update',		'admin-update.php']//,
    //['Backup',		'admin-config.php'],
    //['Upgrade',		'admin-upgrade.php'],
    //['Logout',		'logout.php']
  ];

  var highlight;
  var name = myName();
  var frag = document.createDocumentFragment();
  var m;
  //(for each item in the menu array)
  while(m = menu.shift()){
    //  if(m==1){ 
    //   frag.appendChild(document.createElement('br')); 
    // }else{ 
      var ha = document.createElement('a'); 
      //make link with text of the array item
      ha.appendChild(document.createTextNode(m[0]));
      ha.className = 'indent1';
      frag.appendChild(ha);

      var mm,sm;
      //set up submenu
      if( mm = m[3] ){
        // ha.onclick = toggleChildMenu; 
        ha.id = m[1]; 
        var di = document.createElement('div'); 
        di.id = 'sub-'+m[1];
        di.className = 'hiddenChildMenu'; 
 
        
        // if(m[2]==1){ 
        //   di.className = 'shownChildMenu'; 
        // }else{ 
        //   di.className = 'hiddenChildMenu'; 
        // } 
        
        while(sm = mm.shift()){
          var li = document.createElement('a'); 
          li.appendChild(document.createTextNode(sm[0])); 
          li.className = 'indent2'; 
          li.href = sm[1]; 
          di.appendChild(li);
          if( name == sm[1] ){ 
            di.className = 'shownChildMenu'; 
            li.className += ' electMenu'; 
            highlight=li.parentNode.id.substring(4); 
          }
        }
        frag.appendChild(di);
      }else{
        ha.href = m[1];
        if(m[1]==name){ ha.className += ' electMenuParent'; }
      } //end else
    // } //end else 
  } //end while
    E('navi').appendChild(frag);

    $('#navi').prepend(
      $(document.createElement('img'))
        .prop("id","headlogo")
        .prop("src","images/menuHeader.gif"),
      $(document.createElement('br')),  
      $(document.createElement('br')),  
      $(document.createElement('br')),  
      $(document.createElement('br')),
      $(document.createElement('br')),  
      $(document.createElement('br'))  

    )

    if(highlight != undefined){ 
      E(highlight).className += ' electMenuParent'; 
    }

  $('#tools').click(function() {
    $('#sub-tools').toggle();
  })
  $('#sabaivpn').click(function() {
    $('#sub-sabaivpn').toggle();
  })

  $('.indent1').click(function(){
    $('.indent1').removeClass('electMenu1');
    $(this).addClass('electMenu1')
  })
}




var hidden;

function requeue(){
var queue = []; var workingNow = false; var me = this; var client; var current = {};
this.handle = function(){ if((client!=null)&&(client.readyState == 4)&&(client.status==200)){ current.handler(client.responseText); me.crunch(); } }
this.request = function(){ client = new XMLHttpRequest(); client.onreadystatechange = me.handle; client.open(current.type||'POST',current.path,true); client.setRequestHeader('Content-Type', current.header || "application/x-www-form-urlencoded"); client.send(current.args); }
this.crunch = function(){ if(current = queue.shift()){ workingNow = true; me.request(); }else{ workingNow = false; } }
this.drop = function(q_path, q_handler, q_args, q_type, q_header){ if(q_path!=null) me.add(q_path, q_handler, q_args, q_type, q_header); if(!workingNow){ me.crunch(); } }
this.add = function(q_path, q_handler, q_args, q_type, q_header){ queue.push({ path: q_path, handler: q_handler, args: q_args, type: q_type, header: q_header }); }
}
var que = new requeue();

function verifyFields(){}
function hideUi(hide_msg){ window.hidden_working = true; hide.innerHTML = (hide_msg); hidden.style.display = 'block'; }
function showUi(text){ window.hidden_working = false; hidden.style.display = 'none'; }

function msg(msg){ E('messages').innerHTML=msg; }

function setVPNStats(){
 E('vpnstats').innerHTML = (info.vpn.status == '-')?'':info.vpn.type +' is '+ info.vpn.status +' at '+info.vpn.ip;
 setTimeout(getUpdate,(info.vpn.status == '-')?30000:5000); return;
}
