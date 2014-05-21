#!/bin/bash
# written by William Haynes - Sabai Technology - Apache v2 licence
# copyright 2014 Sabai Technology
 
# this script polls a website to receive back the IP address and Location of the router
 
# routine sends response to calling program
_return(){
        echo "res={ sabai: $1, msg: $2 };";
        exit 0;
}
 
# this receives the data
rm /var/www/stat/ip
wget http://blog.sabaitechnology.com/grabs/routerIP.php?plz=kthx -qO- > /var/www/stat/ip
currentip=$(cat /var/www/stat/ip | awk -F\" '{print $4}')
city=$(cat /var/www/stat/ip | awk -F\" '{print $8}')
region=$(cat /var/www/stat/ip | awk -F\" '{print $12}')
country=$(cat /var/www/stat/ip | awk -F\" '{print $16}')
echo $currentip $city $region $country
if [ -s /var/www/stat/ip ]; then
        logger "Current IP Status received" && _return 1 "Current IP Status Received"
     else
        logger "Failed IP Status Request"  && _return 0 "Failed IP Status Request"
fi
 
# sends response to calling routine
_return(){
        echo "res={ sabai: $1, msg: $2 };";
        exit 0;
}
 
_return 1 "Current IP Status Received"
 
# double checks that you were able to successfully complete
sudo -n ls >/dev/null 2>/dev/null
[ $? -eq 1 ] && _return 0 "Need Sudo powers."