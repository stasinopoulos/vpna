#!/bin/bash

mkdir -p debian/var/www

rsync -av --exclude-from '.gitignore' www debian/var/

dpkg-deb --build debian ./sabai-vpna.deb
