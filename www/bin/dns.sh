#!/bin/bash
dns1=$1
dns2=$2
#change for now
cat > /etc/resolv.conf << EOF
nameserver $dns1
nameserver $dns2
EOF

##change for later
#cat > /etc/network/interfaces << EOF
## This file describes the network interfaces available on your system
## and how to activate them. For more information, see interfaces(5).
#
3# The loopback network interface
#auto lo
#iface lo inet loopback
#
## The primary network interface
#auto eth0
#iface eth0 inet dhcp
#dns-nameservers $dns1 $dns2
#EOF

touch /var/www/stat/dns

#save for persistence 
cat > /var/www/stat/dns << EOF
$dns1
$dns2
EOF

echo "res={ sabai: 1, msg: 'DNS Updated' };";
