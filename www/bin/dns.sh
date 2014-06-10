#!/bin/bash
dns1=$1
dns2=$2
cat > /etc/network/interfaces << EOF
# This file describes the network interfaces available on your system
# and how to activate them. For more information, see interfaces(5).

# The loopback network interface
auto lo
iface lo inet loopback

# The primary network interface
auto eth0
iface eth0 inet dhcp
dns-nameservers $dns1
dns-nameservers $dns2
EOF

cat > /var/www/stat/dns << EOF
$dns1
$dns2
EOF

sudo /etc/init.d/networking restart
