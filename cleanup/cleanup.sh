#!/bin/bash
#########################################
##                                     ##
##  Sabai Technology, Inc - 2014 VPNA  ##
##       Written by Tim Fowler         ##
##     tfowler@sabaitechnology.com     ##
##                                     ##
#########################################


### Autoremove packages from VPNA

sudo apt-get autoremove -y

### Autoclean packages from VPNA

sudo apt-get autoclean -y

### Clean packages from VPNA

sudo apt-get clean -y


### Remove and purge MySQL from VPNA

sudo apt-get remove --purge mysql-server mysql-client mysql-common -y

sudo rm -rf /var/lib/mysql

sudo apt-get autoremove -y

sudo apt-get autoclean -y
 
sudo apt-get clean -y

### Remove and purge Samba

sudo apt-get remove --purge samba* -y

sudo apt-get autoremove -y

sudo apt-get autoclean -y
 
sudo apt-get clean -y

### Update the OS

sudo apt-get update

sudo DEBIAN_FRONTEND=noninteractive apt-get -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" upgrade

sudo apt-get -f install






