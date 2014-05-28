#!/bin/bash

act=$1

_return(){
	echo "res={ sabai: $1, msg: '$2' };";
	exit 0;
}

_on(){
	sudo sed -i 's/Port 31422/Port 22/' /etc/ssh/sshd_config
	sudo sed -i 's/PasswordAuthentication no/PasswordAuthentication yes/' /etc/ssh/sshd_config
	sudo service ssh restart

	sed -i '/ vaelyn@Camus$/d' ~/.ssh/authorized_keys   
	
	_return 1 "SSH On"
}

_off(){
	
	_return 1 "SSH Off"
}



case $act in
	on)	_on	;;
	off)	_off	;;
esac


