---
layout: page
title: mod_vd #_
contents:
 Files:        files
 Installation: installation
 Credits:      credits
 "TIP: How to map subdomains using mod_vd": mapping-subdomains #_
---

Here I am hosting a copy of Anthony Howe's `mod_vd` Apache 2 module
(version 2.0), because I had an extremely difficult time finding it while
setting up my new VPS.

Please note that
**<span style="background-color: #ffff00;">
 I will NOT provide support for this module
</span>**, because I did not write it.  I'm simply hosting a copy of it here
to be nice to people who want it.

## Files

* [mod_vd.c](https://uploads.s.zeid.me/mod_vd-2.0/mod_vd.c)
  - this is all you need to build it on &#x2a;nix
* [LICENSE.TXT](https://uploads.s.zeid.me/mod_vd-2.0/LICENSE.TXT)
* [index.shtml](https://uploads.s.zeid.me/mod_vd-2.0/index.shtml)
  - documentation
* [Full archive for the NetWare build in which I found this](https://uploads.s.zeid.me/mod_vd-2.0-2.2.10-nw.zip)
* [Browse the archive](https://uploads.srwz.us/mod_vd-2.0/)

## Installation

Run

    apxs2 -a -i -c mod_vd.c

as root, and then restart Apache.  On Ubuntu (and possibly other distros)
you'll need to install the Apache development packages (on Ubuntu, I think
these are `apache2-threaded-dev` for threaded Apache (`apache2-mpm-worker`)
or `apache2-prefork-dev` for non-threaded (`apache2-mpm-prefork`), and I think
the default on Ubuntu is non-threaded).

I've tested this on this server, which <del>is</del> was running
Ubuntu Minimal 10.04 x86 with Apache 2.2.14 (packages `apache2-mpm-prefork`
and `apache2-prefork-dev` 2.2.14-5ubuntu8) at the time of this writing.

## Credits

**mod_vd is copyright 2003 by Anthony Howe**.  The reason I'm hosting this
is because he (quite rudely) removed all of his Apache modules from his site
with [no explanation](http://www.snert.com/Software/apache.html) (and also saying
that requests for explanation and archives will be ignored), and it was very
difficult for me to find.  (The license does allow non-commercial redistribution
without modification, provided that the license info remains intact, which is what
I have done here.)

I found the source file in the archive for a NetWare build of it I found
[here](http://www.gknw.de/development/apache/httpd-2.2/netware/modules/mod_vd-2.0-2.2.10-nw.zip).  Thanks to whoever maintains that site for hosting it!

The original Web site for mod_vd, which has of course been removed, is
[here](http://www.snert.com/Software/mod_vd/index.shtml).  The archive contains
a (maybe older) [copy of it](https://uploads.s.zeid.me/mod_vd-2.0/index.shtml).

## TIP:  How to map subdomains using mod_vd {#mapping-subdomains}
To use mod_vd to map subdomains to a corresponding directory in your document
root, like this:

    http://sub.domain.example/ -> /www/domain.example/sub

or

    http://c.b.a.domain.example/ -> /www/domain.example/a/b/c

use this in your configuration file (this also works in vhosts):

    <IfModule mod_vd.c>
        VdEnable on
        VdChopSuffix 2
        VdPathPrefix /path/to/document/root
    </IfModule>

Be sure to change the value of `VdChopSuffix` if your domain (without subdomain)
has anything other than two levels (eg. john.doe.name = 3, localhost = 1).

(I just copied this out of the vhost conf file from my old shared hosting account
with Joyent, who uses mod_vd.)
