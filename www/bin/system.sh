#!/bin/bash

act=$1

_reboot(){
	sudo reboot
}

_shutdown(){
	sudo shutdown -H now
}

case $act in
	reboot)	_reboot	;;
	shutdown)	_shutdown	;;
esac