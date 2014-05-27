sudo apt-get install --assume-yes squid
rm /etc/squid3/squid.conf
cat > /etc/squid3/squid.conf << EOF
# Access Lists
acl manager proto cache_object
acl localhost src 127.0.0.1/32 ::1
acl to_localhost dst 127.0.0.0/8 0.0.0.0/32 ::1
acl SSL_ports port 443
acl Safe_ports port 80                # http
acl Safe_ports port 21                # ftp
acl Safe_ports port 443                # https
acl Safe_ports port 70                # gopher
acl Safe_ports port 210                # wais
acl Safe_ports port 1025-65535        # unregistered ports
acl Safe_ports port 280                # http-mgmt
acl Safe_ports port 488                # gss-http
acl Safe_ports port 591                # filemaker
acl Safe_ports port 777                # multiling http
acl CONNECT method CONNECT
acl sabainet src 192.168.3.0/24
# Only allow cachemgr access from localhost
http_access allow manager localhost
http_access deny manager
# from where browsing should be allowed
http_access allow localhost
http_access allow sabainet
# And finally deny all other access to this proxy
http_access deny all
# Squid server port to listen to
http_port 8888
# Leave coredumps in the first cache dir
coredump_dir /var/spool/squid3
# Add any of your own refresh_pattern entries above these.
refresh_pattern ^ftp:                1440        20%        10080
refresh_pattern ^gopher:        1440        0%        1440
refresh_pattern -i (/cgi-bin/|\?) 0        0%        0
refresh_pattern (Release|Packages(.gz)*)$      0       20%     2880
# example lin deb packages
#refresh_pattern (\.deb|\.udeb)$   129600 100% 129600
refresh_pattern .                0        20%        4320
#Turn IP Forwarding off
forwarded_for off
# Machine Hostname
visible_hostname sabaiproxy
EOF
# the ip address and mask of the device
ipaddr=$(ip route | grep -e "/24 dev eth0" | awk -F: '{print $0}' | awk '{print $1}')
# the proxy address and mask in the configuration file
proxyaddr=$(cat /etc/squid3/squid.conf | grep -e "acl sabainet src" | awk -F: '{print $0}' | awk '{print $4}')
# replace the ip address and mask if necessary
if ! [ $ipaddr = $proxyaddr ]; then
        logger "Proxy setup: address not equal" $proxyaddr $ipaddr;
        sed -i "s#$proxyaddr#$ipaddr#" /etc/squid3/squid.conf
fi
 
service squid3 stop
echo "Proxy Stopped" > /var/www/stat/proxy.connected