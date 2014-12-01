---
layout: post
title:  '"Address already in use" error when OpenVPN is NOT running'
date:   2011-08-31 03:16:33Z
tags: 
 - openvpn
 - rant
---

So for the past week or so I've been trying to set up a dual-stack-payload OpenVPN
server.  I was playing around with some IPv6 route settings earlier when it started
doing this:

    $ sudo openvpn /etc/openvpn/server.conf
    Wed Aug 31 02:41:06 2011 Herp derp, herpity derp derp...
    Wed Aug 31 02:41:06 2011 TCP/UDP: Socket bind failed on local
    address [AF_INET]64.71.167.212:1194: Address already in use
    Wed Aug 31 02:41:06 2011 Exiting due to fatal error

    $ echo "OH FUCK WHY WONT IT WORK!!!!1!1one!!1!"
    OH FUCK WHY WONT IT WORK!!!!1!1one!!1!

<!---->

    $ cat /etc/openvpn/up.sh
    #!/bin/sh

    sysctl -w net.ipv4.ip_forward=1
    sysctl -w net.ipv6.conf.all.forwarding=1

    ip link set $dev up promisc on mtu $tun_mtu

    brctl addif br0 $dev

    iptables -t nat -A POSTROUTING -s 10.4.4.0/24 -o eth0 -j MASQUERADE

    service radvd restart

    true

<!---->

    $ sudo lsof -i ":openvpn"
    COMMAND  PID  USER   FD   TYPE DEVICE SIZE/OFF NODE NAME
    radvd   2486  root    6u  IPv4  12816      0t0  TCP srwz.us:openvpn (LISTEN)
    radvd   2487 radvd    6u  IPv4  12816      0t0  TCP srwz.us:openvpn (LISTEN)

**<em>WHAT???</em> radvd is listening on OpenVPN's port?**

Some background:  I was restarting radvd in the up script because it's set to
advertise on tap0, but tap0 doesn't exist when the system boots, so instead of
messing with the init scripts, I decided to just restart radvd in the up script.
However, **since the up script is executed as a subprocess of OpenVPN, it
apparently inherits OpenVPN's sockets, and radvd in turn inherits the shell script's
sockets**, causing problems when you restart OpenVPN (even with SIGHUP, I would
assume). * 

Now I do have `IgnoreIfMissing on;` in my radvd.conf file (it's not the default
yet in the radvd 1.7 that ships with natty), but I didn't realize that starting
radvd *succeeded* when tap0 didn't exist, which is why I was doing it in the up
file.  radvd rereads its config file on SIGHUP, so to fix the issue, I simply
changed this line in the up script:

    service radvd restart

to:

    kill -HUP `cat /var/run/radvd/radvd.pid`

and restarting OpenVPN worked again.

Time to go to bed now.  I hope this helps someone.

&#x2a; Disclaimer:  I don't have [200 years of UNIX experience](http://dilbert.com/strips/comic/2008-02-29/)
like [some people do](http://dilbert.com/strips/comic/2008-03-01/), so I may be a
little bit wrong about this.  But I'm probably right.  :)
