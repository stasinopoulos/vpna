#!/bin/bash
act=$1

sys='/var/www/bin/sys/ovpn'
pidf='/var/www/stat/ovpn.pid'

_return(){
	echo "res={ sabai: $1, msg: '$2' };";
	exit 0;
}

_erase(){
	killall openvpn 2>/dev/null
}

_stop(){
	timeout=15
	[ ! -e $pidf ] && _erase
	[ -e $pidf ] && pid=$(cat $pidf) && [ -n "$pid" ] && kill $pid && while [ -n "$(ps --no-heading $pid)" ] && [ $timeout -gt 0 ]; do (( timeout-- )); sleep 1; done
	[ "$act" == "stop" ] && _return 1 "OpenVPN stopped."
}

_start(){
	_stop;
	[ ! -e /var/www/usr/ovpn.current ] && _return 0 "No file loaded."
	:>/var/www/stat/ovpn.log
	chmod +r /var/www/stat/ovpn.log
	./pptp.sh stop 
	./l2tp.sh stop
	openvpn /var/www/sys/ovpn.sabai
	timeout=15
	while [ ! -e /var/www/sys/ovpn.connected ] && [ $timeout -gt 0 ]; do (( timeout-- )); sleep 1; done
	_return 1 "OpenVPN started.";
}

sudo -n ls >/dev/null 2>/dev/null
[ $? -eq 1 ] && _return 0 "Need Sudo powers."
([ -z "$act" ] ) && _return 0 "Missing arguments: act=$act."

echo "$# $*" > /tmp/ovpn.txt

case $act in
	start)	_start	;;
	stop)	_stop	;;
	erase)	_erase	;;
esac
