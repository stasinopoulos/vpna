#!/bin/bash

mkdir -p debian/var/www

rsync -av --exclude "usr" www/ debian/var/www/

dpkg-deb --build debian ./sabai-vpna.deb
