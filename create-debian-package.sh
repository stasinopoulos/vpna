#!/bin/bash


rsync -vau www/ debian/var/www/

dpkg-deb --build debian ./sabai-vpna.deb
