#!/bin/bash

# logFile=/tmp/update.$(head -c8 /dev/urandom | md5sum | tr -d " -" | head -c8).log

export DEBIAN_FRONTEND=noninteractive
ppas="\
ppa:ondrej/php5 \
ppa:chris-lea/node.js";
apt-get update >/dev/null 2>&1 && apt-get install -y software-properties-common python-software-properties && for ppa in $ppas; do
	add-apt-repository -y "$ppa";
done
apt-key add - <<SKEY
-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: GnuPG v1.4.11 (GNU/Linux)

mQINBFM5YucBEAD0qghTs79e8t7zauQ/bO2DdVmfYNpbYDqqBUJpDzwXN4pQFJyT
naahEvngbNhilxjXH1/mbTKUVhGPkfSXqBJo8ftXrAjeD3QCTj0raWjqX93kXsPx
evDntkHl8M06YIhz6/WDWNB4C5/1MwqMRiNNXDEWD6CETP61E8ysL4YUfRVgi+Gu
K00ghdw+6PG7R9dPPlH7HZ37nYH9gENGvQsUuUCLYtHZTlMgfy1xMJVfrXJhF7Xi
NntJf++FJ0ejbqpYMajgrkpyqmxC571RK9FR/mnKJShPrhaN5WvziActbxzEGhzd
MEY/tqPGwcOgXGktFUUJ7nvx9yAzDsNLxVWL3GDWopa0yK2aDiC9789XVf3v4ftX
IE6pv4Wl4zfxiu41/FxMKjFbQ2uozYUObafjpHxW66VdbctJu8ztExs9m+oJQVFJ
+sZ6/iicXY8Snb9JPK/drDCODPp6eI9FD/n8wi2+Go3vlD53/N6bNEmyJ9N+5HRo
6Q7xZpW8CVOPmQ1uOcEke+npBoQZNSKbM7cWaVmD7Ca0TbdIr+mlPuO/qjb6nwA7
hBIQrK/+pNVU3FppxwRthx1Kcqa9z+09p9/s65RlSjMX57ukSfZgCZv8Xikzyx6e
WxicHEe+BcWQjGQZC2VRSJ024/1+2QvQXWMTLKbQopxtZifazeWhkBzcBwARAQAB
tDRTYWJhaSBUZWNobm9sb2d5IChKYWlSbykgPGphaXJvQHNhYmFpdGVjaG5vbG9n
eS5jb20+iQI4BBMBAgAiBQJTOWLnAhsDBgsJCAcDAgYVCAIJCgsEFgIDAQIeAQIX
gAAKCRDSa/ka4h/aCJh2D/0USVCiPQ0I6iV2TDQmNKkxfo3nm7O9pJgw/IAa6lWt
mwxfDxgFrn6uFIUL3H+nfGwsh7xokEVXgsOWBH/AT9NwPeElEZHW1kW25CJPQMGo
cEnGbQ6309pD/JcIPcNn4WnC8GFuyrK5AXPdI2a2Lh7VCG17SMA581lxW92X5Wuh
J1SZm17/5m6U9A9hJidO++N4AsPd/pi7y1vkzdcyMwFLLCI+XNfeBqkLKEXpK7p1
iV+ww/lbFa7EbfVYCv0X+TTb8wEYslIuIAFv6BnVKV1zvFyL5U+MYw8zTFMNsbXK
vxO6J1V/Jx9xuM5uy1NOszNzb0nEsiFh+b1E29DJAK9OTVtKgjp6VozwfTIe/yNE
0zc5SFxdKZEUtBmHaHv1PTCF2FoNK60yehSwjCrRy24dE683Ax4bI3hzUIZW3Fhq
+dagEBwDDwyqdaGjlzmcJFmrCk+TNmmbnLPtWfHws3ZCX6lMSk18T1x5DlsjxG/m
K4ZJeoJuLLcGrVQfjzuno/eTrbd9+xuzIWrwq85lvVqZeVCgsSxFjUjzJ2kk8ZKS
fVuVFqq9xITmyzgWcqgz+6xhxNU4ibMm+0JpHjOjcfZk0mSjxsjyKSBWKlkKEenf
R2yyuRHCGMXPAKtC5+VK7ckvZgFh7dySzcVyZhV4AEMDCJ5JSq+vNuwKFL8sw0Ob
Sg==
=IA1W
-----END PGP PUBLIC KEY BLOCK-----
SKEY

echo "deb http://sabai:sabaipass@repo.sabaitechnology.com/sabai vpna main" >/etc/apt/sources.list.d/SabaiTechnologyVPNA.list
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
