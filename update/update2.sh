#!/bin/bash

# logFile=/tmp/update.$(head -c8 /dev/urandom | md5sum | tr -d " -" | head -c8).log

export DEBIAN_FRONTEND=noninteractive
ppas="\
ppa:ondrej/php5 \
ppa:chris-lea/node.js";
apt-get update >/dev/null 2>&1 && apt-get install -y software-properties-common python-software-properties && for ppa in $ppas; do
        add-apt-repository -y "$ppa";
done

echo "deb http://192.168.222.198/repos/apt/debain sabai-vpna main" >/etc/apt/sources.list.d/SabaiTechnologyVPNA.list
apt-get update >/dev/null 2>&1
#echo "apt-get -y -o Dpkg::Options::=--force-confnew install sabai-vpna-beta" >/var/www/sabai-vpna-beta-install.sh

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
apt-get -y -o Dpkg::Options::=--force-confnew install sabai-vpna-beta
SINST

touch /var/www/sys/upgrade_scheduled
chmod +x /var/www/sabai-vpna-beta-install.sh
at -f /var/www/sabai-vpna-beta-install.sh now + 1 minute
echo "The VPNA Update Beta installer is running. Please refresh this page for status updates."

