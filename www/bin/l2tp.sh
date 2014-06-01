#!/bin/bash
act=$1
_u=$2
_p=$3
_k=$4
_s=$5
_l="$(ip -o -f inet addr show dev eth0 | egrep -o 'inet ([0-9]{0,3}.){3}[0-9]{0,3}' | cut -d ' ' -f2)"
vpn_command="$1 $2 $3 $4 $5"

_return(){ echo "res={ sabai: $1, msg: '$2' };"; exit 0; }
_badarg(){ _return 0 "Missing arguments: act=$act, user=$_u, pass=$_p, key=$_k, local=$_l, server=$_s."; }

_redo(){
        at now + 24 hours -f /var/www/bin/restart_l2tp.sh
}
_setup(){
	sysctl net.ipv4.conf.all.send_redirects=0; sysctl net.ipv4.conf.all.accept_redirects=0;
	echo -e "include /var/lib/openswan/ipsec.secrets.inc\n$_l $_s : PSK \"$_k\"" >/var/www/usr/l2tp.ipsec.secrets # /etc/ipsec.secrets --> /var/www/usr/ipsec.secrets
	echo -e "version\t2.0\nconfig setup\n\tnat_traversal=yes\n\tvirtual_private=%v4:10.0.0.0/8,%v4:192.168.0.0/16,%v4:172.16.0.0/12\n\toe=off\n\tprotostack=netkey\n\tinterfaces=\"%defaultroute\"\n\tplutoopts=\"--interface=eth0\"\n\tforce_keepalive=yes\n\tkeep_alive=3600\nconn SABAI\n\tauthby=secret\n\tpfs=no\n\tauto=add\n\tkeyingtries=3\n\tdpddelay=30\n\tdpdtimeout=120\n\tdpdaction=restart\n\trekey=yes\n\tikelifetime=8h\n\tkeylife=1h\n\ttype=transport\n\tleft=$_l\n\tleftnexthop=%defaultroute\n\tleftprotoport=17/1701\n\tright=$_s\n\trightprotoport=17/1701" >/var/www/usr/l2tp.ipsec.conf # /etc/ipsec.conf --> /var/www/usr/ipsec.conf
	echo -e "unit 7\nipcp-accept-local\nipcp-accept-remote\nrefuse-eap\nrequire-mschap-v2\nnoauth\nidle 1800\nmtu 1410\nmru 1410\ndefaultroute\nusepeerdns\ndebug\nlock\nconnect-delay 5000\nname $_u\npassword $_p\nip-up-script /var/www/vpn/l2tp.up\nip-down-script /var/www/vpn/l2tp.dn" >/var/www/usr/l2tp.options # path in l2tp.conf
	echo -e "[lac sabai]\nlns = $_s\nppp debug = yes\npppoptfile = /var/www/usr/l2tp.options\nlength bit = yes" >/var/www/usr/l2tp.conf # /etc/xl2tpd/xl2tpd.conf --> /var/www/usr/l2tp.conf
}
_stop(){
        echo "d sabai" > /var/run/xl2tpd/l2tp-control;
        sleep 2; while [ -e /var/www/stat/fw.run ]; do sleep 2; done
        service xl2tpd stop; sleep 1; service ipsec stop; sleep 1;
        timeout=25;
        while [ -e /var/run/pluto/pluto.ctl ] && [ -e /var/run/xl2tpd.pid ] && [ $timeout -gt 0 ]; do sleep 1; (( timeout-- )); done
        if [ -e /var/run/pluto/pluto.ctl ] || [ -e /var/run/xl2tpd.pid ]; then
                _return 0 "L2TP failed to stop."
        else
                echo -e "#!/bin/bash\nlogger no VPN initiated on startup" > /var/www/stat/vpn.command
                [ -n "$_s" ] && ip route del $_s
                [ "$act" == "stop" ] && _return 1 "L2TP stopped."
        fi
}

_start(){
	_stop
	( [ -z "$_u" ] || [ -z "$_p" ] || [ -z "$_k" ] || [ -z "$_l" ] || [ -z "$_s" ] ) && _badargs
	ip route add $_s via $(ip route ls to 0/0 dev eth0|cut -d ' ' -f3) dev eth0
	./pptp.sh stop
	./ovpn.sh stop
	_setup
	service ipsec start && service xl2tpd start
	while [ ! -e /var/run/pluto/pluto.ctl ] || [ ! -e /var/run/xl2tpd.pid ]; do sleep 2; done
	sleep 5;
	ipsec auto --up SABAI
	timeout=25;
	while [ -z "$(ipsec setup status|grep -e '1 tunnels up')" ] && [ $timeout -gt 0 ]; do sleep 1; (( timeout-- )); done
	if [ -z "$(ipsec setup status|grep -e '1 tunnels up')" ]; then
		_stop
		_return 0 "L2TP failed to start."
	else
		echo "c sabai" >/var/run/xl2tpd/l2tp-control
		kill $logpid;
		echo -e "#!/bin/bash\nsh /var/www/bin/l2tp.sh $vpn_command\nlogger L2TP initiated on startup" > /var/www/stat/vpn.command
		_redo
		_return 1 "L2TP started."
	fi
}

sudo -n ls >/dev/null 2>/dev/null || _return 0 "Need Sudo powers."

case $act in
	start)	_start	;;
	stop)	_stop	;;
	*)	_badarg	;;
esac
