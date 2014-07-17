#!/bin/bash

act=$1

_return(){
	echo "res={ sabai: $1, msg: '$2' };";
	exit 0;
}

_reboot(){
	if [ -e /var/stat/l2tp.connected]; then
		service xl2tpd stop;
		service ipsec stop;
		sleep 5
	fi
	reboot
	_return 1 "Rebooting...  Please wait 30 seconds"
}

_shutdown(){
        if [ -e /var/stat/l2tp.connected]; then
                service xl2tpd stop;
                service ipsec stop;
                sleep 5
        fi
	shutdown -P now
	_return 1 "Shut Down Complete"
}

_dhcp(){
	dhclient eth0
	_return 1 "Lease Reset"
}


case $act in
	reboot)	_reboot	;;
	shutdown)	_shutdown	;;
	dhcp) _dhcp ;;
esac
