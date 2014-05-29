Array.prototype.find = function(v){ 
  var i = f.length; 
  while(this[--i]!=v && i>=0); 
  return i; 
}

Array.prototype.remove = function(v){ 
  var i = this.find(v); 
  if(i!=-1){ 
    this.splice(i, 1); 
    return true; 
  }else{ 
    return false; 
  } 
}

function E(e){ 
  return (typeof(e) == 'string') ? document.getElementById(e) : e; 
}

function peekaboo(id){ 
  var e = E(id); 
  e.type = e.type=='password' ? 'text' : 'password'; 
}

function reloadPage(){ 
  document.location.reload(1); 
}

var cookie = {
  set: function(key, value, days){ 
    document.cookie = 'vpna_' + key + '=' + value + '; expires=' + (new Date(new Date().getTime() + ((days ? days : 14) * 86400000))).toUTCString() + '; path=/'; 
  },
  get: function(key){ 
    var r = ('; ' + document.cookie + ';').match('; vpna_' + key + '=(.*?);'); 
    return r ? r[1] : null; 
  },
  unset: function(key) { 
    document.cookie = 'vpna_' + key + '=; expires=' + (new Date(1)).toUTCString() + '; path=/'; 
  }
};

function toggleChildMenu(){ 
  var ch = E('sub-'+this.id); 
  ch.className = (ch.className == 'shownChildMenu') ? 'hiddenChildMenu' : 'shownChildMenu'; 
}


function navi(){ 
  var menu = [
    ['Status', 'index.php', 'status'],
    ['VPN', 'sabaivpn', 0, 
      [
        ['PPTP',  'sabaivpn-pptp.php', 'pptp'],
        ['L2TP',  'sabaivpn-l2tp.php', 'l2tp'],
        ['OpenVPN', 'sabaivpn-ovpn.php', 'ovpn']
      ] 
    ],
    ['Settings', '/settings.php', 'settings'],
    ['Logs',    '/log.php', 'log'],
    ['Diagnostics', 'tools', 0, 
      [
        ['Ping',  'tools.php?tool=ping', 'ping'],
        ['Trace', 'tools.php?tool=trace', 'trace'],
        ['Route', 'tools.php?tool=route', 'route'],
        ['System',  'tools.php?tool=shell', 'shell'] 
      ] 
    ],
    ['About',   '/admin-about.php', 'about'],
    ['Update',    '/admin-update.php', 'update']//,
    //['Backup',    'admin-config.php', 'config'],
    //['Upgrade',   'admin-upgrade.php', 'upgrade'],
    //['Logout',    'logout.php', 'logout']
  ];

  // var frag = document.createDocumentFragment();
  $('#navi').append(
    $(document.createElement('ul'))
      .prop('id', 'navButtons')
  )

  for (i=0; i<menu.length; i++) {
    var divName= menu[i][0]+'sub-menu';
    if( menu[i][0] == 'VPN' || menu[i][0] == 'Diagnostics') {
      $('#navButtons').append(
        $(document.createElement('li'))
          .prop('id', menu[i][2])
          .click(function(){
            $(this).next('div').toggle()
          })
          .append(
            $(document.createElement('a'))
              .html(menu[i][0])
              .addClass('indent1')
          )
      )
      .append(
        $(document.createElement('div'))
          .prop('id', divName)  
          .css('display', 'none')
      )

      for (x=0; x<menu[i][3].length; x++){
        $('#'+divName).append(
          $(document.createElement('li'))
            .prop('id', menu[i][3][x][2])
            .append(
              $(document.createElement('a'))
                .html(menu[i][3][x][0])
                .addClass('indent2')
                .prop('href',menu[i][3][x][1])
            )
        )
      }
      
    }else {
      $('#navButtons').append(
        $(document.createElement('li'))
          .prop('id', menu[i][2])
          .append(
            $(document.createElement('a'))
              .html(menu[i][0])
              .addClass('indent1')
              .prop('href', menu[i][1])
          )
      )
    }
  }
  

  
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


}

var hidden;

function requeue(){
  var queue = []; 
  var workingNow = false; 
  var me = this; 
  var client; 
  var current = {};

  this.handle = function(){ 
    if((client!=null)&&(client.readyState == 4)&&(client.status==200)){ 
      current.handler(client.responseText); 
      me.crunch(); 
    } 
  }

  this.request = function(){ 
    client = new XMLHttpRequest(); 
    client.onreadystatechange = me.handle; 
    client.open(current.type||'POST',current.path,true); 
    client.setRequestHeader('Content-Type', current.header || "application/x-www-form-urlencoded"); 
    client.send(current.args); 
  }

  this.crunch = function(){ 
    if(current = queue.shift()){ 
      workingNow = true; 
      me.request(); 
    }else{ 
      workingNow = false; 
    } 
  }

  this.drop = function(q_path, q_handler, q_args, q_type, q_header){ 
    if(q_path!=null) 
      me.add(q_path, q_handler, q_args, q_type, q_header); 
    
    if(!workingNow){ 
      me.crunch(); 
    } 
  }

  this.add = function(q_path, q_handler, q_args, q_type, q_header){ 
    queue.push(
      { 
        path: q_path, 
        handler: q_handler, 
        args: q_args, 
        type: q_type, 
        header: q_header 
      }
    ); 
  }
}

var que = new requeue();

function verifyFields(){}

function hideUi(hide_msg){ 
  window.hidden_working = true; 
  hide.innerHTML = (hide_msg); 
  hidden.style.display = 'block'; 
}

function showUi(text){ 
  window.hidden_working = false; 
  hidden.style.display = 'none'; 
}

function msg(msg){ 
  E('messages').innerHTML=msg; 
}

function setVPNStats(){
  $('#vpnstats').innerHTML = (info.vpn.status == '-')?'':info.vpn.type +' is '+ info.vpn.status +' at '+info.vpn.ip;
  setTimeout(getUpdate,(info.vpn.status == '-')?30000:5000); 
  return;
}
