#!/bin/bash
act=$1
_u=$2
_p=$3
_s=$4

pidf="/var/run/ppp7.pid"
opts="/var/www/usr/pptp.options"

_return(){
	echo "res={ sabai: $1, msg: '$2' };";
	exit 0;
}

_badarg(){ _return 0 "Missing arguments: act=$act, user=$_u, pass=$_p, server=$_s."; }

_setup(){
	echo -e "pty \"pptp $_s --nolaunchpppd\"\nname $_u\npassword $_p
unit 7\nlock\nrefuse-pap\nrefuse-eap\nrefuse-chap\nrefuse-mschap\nnobsdcomp\nnopcomp\nnoaccomp\nnovj\nnodeflate\nrequire-mppe-128\nrequire-mschap-v2\npersist\nmaxfail 0\ndefaultroute\nusepeerdns\nnoauth\ndefault-asyncmap\nlcp-echo-interval 15\nlcp-echo-failure 6\nlcp-echo-adaptive\nholdoff 20\nmtu 1400
ip-up-script /var/www/vpn/pptp.up\nip-down-script /var/www/vpn/pptp.dn" > $opts
}

_stop(){
	timeout=15
	[ -e $pidf ] && pid=$(cat $pidf) && kill $pid && while [ -n "$(ps --no-heading $pid)" ] && [ $timeout -gt 0 ]; do (( timeout-- )); sleep 1; done
	if [ -n "$_s" ]; then
		lastroute="$(ip route show $_s)"
		[ -n "$lastroute" ] && ip route del $lastroute
	fi
	[ "$act" == "stop" ] && _return 1 "PPTP stopped."
}

_start(){
	_stop;
	([ -z "$_u" ] || [ -z "$_p" ] || [ -z "$_s" ] ) && _badarg
	_setup;
	./l2tp.sh stop
	./ovpn.sh stop
	pppd file $opts &
	timeout=15
	while [ $(cat /var/www/stat/pptp.connected) -eq 0 ] && [ $timeout -gt 0 ]; do (( timeout-- )); sleep 1; done
	_return 1 "PPTP started.";
}

sudo -n ls >/dev/null 2>/dev/null || _return 0 "Need Sudo powers."

case $act in
	start)	_start	;;
	stop)	_stop	;;
	*)	_badarg	;;
esac
