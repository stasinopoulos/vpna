#!/bin/bash

### A Hope and  Prayer
sudo dpkg --remove linux-server

sudo dpkg --remove linux-headers-server

sudo dpkg --remove linux-image-server

touch /etc/xl2tpd/xl2tpd.conf

sudo apt-get -f install -y

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

## Update Openssl and Openvpn and NTP server

sudo apt-get update

sudo apt-get install -y openssl openvpn libclass-data-inheritable-perl ntp
echo " OPENSSL INSTALLED"

# Install Reset Control 
sudo wget -N http://198.211.117.53/repos/apt/debian/pool/main/libl/liblinux-input-perl/liblinux-input-perl_1.03-1_all.deb
sudo dpkg -i liblinux-input-perl_1.03-1_all.deb
echo "This step is done"

sudo wget -N http://198.211.117.53/repos/apt/debian/pool/main/s/sabai-vpna/sabai-vpna_2.0_amd64.deb
cp sabai-vpna_2.0_amd64.deb /home/sabai/sabai-vpna.deb

sudo apt-get remove sabai-vpna -y
### Update the OS

#sudo apt-get update 

#sudo DEBIAN_FRONTEND=noninteractive apt-get -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" upgrade

#sudo apt-get -f install

export DEBIAN_FRONTEND=noninteractive

apt-key add - <<SKEY
-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: GnuPG v1.4.11 (GNU/Linux)

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
=zugN
-----END PGP PUBLIC KEY BLOCK-----
SKEY

echo "deb http://198.211.117.53/repos/apt/debian vpna main" >>/etc/apt/sources.list
apt-get update >/dev/null 2>&1
#echo "apt-get -y -o Dpkg::Options::=--force-confnew install sabai-vpna" >/var/www/sabai-vpna-beta-install.sh

#echo "The VPNA Update Beta installer is still running." > /var/www/admin-update.php
cat >/var/www/admin-updating.php <<SPHP
<?php
 if(file_exists("/var/www/sys/upgrade_scheduled")){
  echo "The VPNA Update Beta installer is scheduled.";
 }else{
  if(file_exists("/var/www/sys/upgrading")){
   echo "The VPNA Update Beta installer is still running.";
  }else{
   echo "The VPNA Update Beta installer appears to have finished; please refresh the page.";
  }
 }
?>
SPHP

cat >/var/www/sabai-vpna-beta-install.sh <<SINST
#!/bin/bash
cp /var/www/admin-update.php /var/www/admin-updated.php
mv /var/www/admin-updating.php /var/www/admin-update.php
apt-get update
apt-get -y -o Dpkg::Options::=--force-confnew install sabai-vpna
touch /etc/xl2tpd/xl2tpd.conf
apt-get -f install
sudo reboot
SINST

touch /var/www/sys/upgrade_scheduled
chmod +x /var/www/sabai-vpna-beta-install.sh
at -f /var/www/sabai-vpna-beta-install.sh now + 1 minute
echo "The VPNA Update Beta installer is running. Please refresh this page for status updates."

