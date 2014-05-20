#!/bin/bash

mkdir -p debian/var/www

rsync -vau www/ debian/var/www/

dpkg-deb --build debian ./sabai-vpna.deb
