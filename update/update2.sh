#!/bin/bash

export DEBIAN_FRONTEND=noninteractive

apt-key add - <<SKEY
-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: GnuPG v1.4.11 (GNU/Linux)

mQENBFN8t8YBCAD1pQSB/K2iu0uOgjy9ow21opxQ/uXPwGAuf4MsVI2F68L+gNLi
EW3qxZOgGZAYbZVOURBpfQ5cgO96e5Nrm4iWKzYAZYc7oQ9Htbo88nKi+U2SXeex
wxKUZLqL5Pkey9M3EH/wjU00PrtQtYDCbLSuYce5BD0VRJxQ10mD5moUIR2tTkxw
ERuj9QlrIRDjPvkhlXt5uu+EfdmwMUrdaYQrkeOJZe6sKJT0apQcwrng5Cn9iHpQ
1HAZBL9goeK6Z+n2vtARsHFXt9vEABGnmIg+KbAuXY+tsaGuDDQtG3nyVzIbayz9
r7zatTRI3/56wdPqnRFDmUlzX4Rp2ukmS7OPABEBAAG0K1NhYmFpIFRlY2hub2xv
Z3kgPGluZm9Ac2FiYWl0ZWNobm9sb2d5LmNvbT6JATgEEwECACIFAlN8t8YCGwMG
CwkIBwMCBhUIAgkKCwQWAgMBAh4BAheAAAoJEG4Jqtg5YKSRGKwH/jlwc9gnx1YG
EUtxA/e4zf7PGXlrShd+fcVvIBouZ3ONVl213X86zel2r0/CzvmR91zauaoynfky
JhOFVFFMR2qKhYSOhxqt2T8e/jOgu1KuEu/K7bUyHTrbHUBXw34SAoBbdM83ecAJ
RTmFXihkylwnHtzvKSdN3g9DbakyuWsABX6iOrjBGl2R7E1ydPlIXWvDoFCNsIoN
voz+6rDzrcKwiNXWccN5XGAKJxpALrtzaJszZ4CHpy3tCnVfi5OrNoNEsRJ0poDf
wprBGKQfnhM0j7ot6+NrfMbNOvsAmxaHqrA2KVQbBcBwX3CbryPh8EZcpHWOxt/6
f6k51O0EF8U=
=uPy9
-----END PGP PUBLIC KEY BLOCK-----
SKEY


echo "deb http://192.168.222.198/repos/apt/debian vpna main" >>/etc/apt/sources.list
apt-get update >/dev/null 2>&1

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
