#!/usr/bin/perl -w
use Linux::Input;

sub reinstall_vpna () {
    for(`dpkg -i /home/sabai/sabai-vpna.deb`) {
	printf;
    }
    printf "DONE\n";
}

$sleepbtn = Linux::Input->new('/dev/input/event1');

while (1) {
    while (my $events = $sleepbtn->poll(.3)) {
	printf "$events \n";
	if ($events > 9000) {
	    printf "RESET!\n";
	    reinstall_vpna();
	}
    }
}


