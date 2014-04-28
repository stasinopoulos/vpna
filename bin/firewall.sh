#!/bin/bash
peekaboo='/var/www/sys/net.peekaboo'
touch /var/www/stat/fw.run
sysctl net.ipv4.ip_forward=1
sysctl net.ipv4.ip_dynaddr=1

#php /var/www/bin/get_remote_ip.php >/dev/null 2>&1 &

subnet="$(ip -f inet -o addr show dev eth0 | egrep -o 'inet ([0-9]{1,3}.){3}[0-9]{1,3}/[0-9]{1,2}' | cut -d' ' -f2)";

if [ x"$IFACE" == x"eth0" ] && [ -n "$subnet" ]; then
 sed -i "/# ~SUBNET BEGIN~/,/# ~SUBNET END~/{ s| Allow from .*| Allow from $subnet|g }" $peekaboo
 service apache2 restart
fi

for i in\
 'INPUT -m state --state INVALID -j DROP'\
 'INPUT -m state --state RELATED,ESTABLISHED -j ACCEPT'\
 'INPUT -i lo -j ACCEPT'\
 'INPUT -p tcp -s '$subnet' --dport 80 -j ACCEPT'\
 'INPUT -p tcp -s '$subnet' --dport 22 -j ACCEPT'\
 'FORWARD -m state --state INVALID -j DROP'\
 'FORWARD -p tcp --tcp-flags SYN,RST SYN -j TCPMSS --clamp-mss-to-pmtu'\
 'FORWARD -m state --state RELATED,ESTABLISHED -j ACCEPT'\
; do
 iptables -C $i 2>/dev/null || iptables -A $i
done

msq='POSTROUTING -t nat -j MASQUERADE -o'
for i in eth0 ppp7 tap0 tun0; do
 ([ -n "$(ifconfig $i 2>/dev/null)" ] && ! iptables -C $msq -o $i 2>/dev/null ) && iptables -A $msq $i
done
rm /var/www/stat/fw.run
