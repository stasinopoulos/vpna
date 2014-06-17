#!/bin/bash

mkdir -p debian/var/www

rsync -av --exclude-from '.gitignore' www debian/var/
rsync -av reset/vpna_reset.conf debian/etc/init/
rsync -av reset/vpna_reset.pl debian/home/sabai/


dpkg-deb --build debian ./sabai-vpna.deb
