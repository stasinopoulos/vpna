#!/bin/bash

case $1 in
 list) find /var/log/* -maxdepth 0 -type f ! -name '*.gz' | sed 's|/var/log/||g' ;;
 all) cat /var/log/$2 ;;
 last) tail /var/log/$2 -n $3 ;;
 find) grep "$4" /var/log/$2 ;;
esac
