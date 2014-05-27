#!/bin/bash
# written by William Haynes - Sabai Technology - Apache v2 licence
# copyright 2014 Sabai Technology

 
# this script allows 2 variables to be passed to it, as documented below:
# act variable is the action sent into the script
act=$1

# the ip address and mask of the device
ipaddr=$(ip route | grep -e "/24 dev eth0" | awk -F: '{print $0}' | awk '{print $1}')


# the proxy address and mask in the configuration file
proxyaddr=$(cat /etc/squid3/squid.conf | grep -e "acl sabainet src" | awk -F: '{print $0}' | awk '{print $4}')



_return(){
   echo "res={ sabai: $1, msg: '$2' };";
   exit 0;
}

_stop(){
   echo "Proxy Stopped" > /var/www/stat/proxy.connected;
   service squid3 stop && _return 1 "Proxy Stopped.";
}

_start(){
    # replace the ip address and mask if necessary
    if [ "$ipaddr" != "$proxyaddr" ]; then
	logger "Proxy setup: address not equal" $proxyaddr $ipaddr;
	sed -i "s#$proxyaddr#$ipaddr#" /etc/squid3/squid.conf
    fi

    echo "Proxy Started" > /var/www/stat/proxy.connected;
    service squid3 restart &&_return 1 "Proxy Started.";
}

sudo -n ls >/dev/null 2>/dev/null
[ $? -eq 1 ] && _return 0 "Need Sudo powers."
([ -z "$act" ] ) && _return 0 "Missing arguments: act=$act."

case $act in
   start)  _start  ;;
   stop)   _stop   ;;
esac

