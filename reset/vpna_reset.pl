#!/usr/bin/perl -w
use Linux::Input;
use Sys::Syslog;
use Sys::Syslog qw(:standard :macros);

openlog("VPNAreset", "", LOG_USER);

sub reinstall_vpna () {
    for(`dpkg -i /home/sabai/sabai-vpna.deb`) {
	print;
    }
    syslog ("notice", "VPNA reset completed");
}

$sleepbtn = Linux::Input->new('/dev/input/event1');

syslog ('info', 'Starting VPNA reset service');

while (1) {
    while (my $events = $sleepbtn->poll(.3)) {
	if ($events > 9000) {
	    syslog('notice', "Initiating VPNA reset");
	    reinstall_vpna();
	}
    }
}


