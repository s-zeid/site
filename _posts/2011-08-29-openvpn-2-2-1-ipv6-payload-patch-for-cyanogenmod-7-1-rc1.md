---
layout: post
title:  OpenVPN 2.2.1 + IPv6 Payload Patch for CyanogenMod 7.1 RC1
date:   2011-08-29 01:50:43Z
tags:   openvpn
---

I've ported [Gert Döring's IPv6 payload patch for OpenVPN](http://www.greenie.net/ipv6/openvpn.html)
to [CyanogenMod](http://www.cyanogenmod.com/).  I want to try to get it into the
CM source tree someday, but here are the goods in the meantime.

* [Binary built for the original CDMA Droid (sholes) on 2011-08-26](https://uploads.s.zeid.me/openvpn-2.2.1-ipv6-cm7.1rc1-sholes-20110826)
  * Install to your phone as _<code>/system/xbin/openvpn</code>_.
  * Change owner and group to <code>root</code> and permissions to <code>0755</code>.
  * May work on other ARM phones running CM, although I haven't tested it on any of
    them except my Droid 1.
  * May not work on other Android ROMs because the paths to ifconfig/route/ip are
    configured at compile time.
  * [SHA-256 sum](https://uploads.s.zeid.me/openvpn-2.2.1-ipv6-cm7.1rc1-sholes-20110826.sha256sum)
* [CyanogenMod patch (valid as of 2011-08-26)](https://uploads.s.zeid.me/openvpn-2.2.1-ipv6-cm7.1rc1-20110826-1.patch.gz)
  * `cd /path/to/cm/source/external/openvpn`
  * `zcat /path/to/openvpn-2.2.1-ipv6-cm7.1rc1-20110826-1.patch.gz | patch -p1`
  * [SHA-256 sum](https://uploads.s.zeid.me/openvpn-2.2.1-ipv6-cm7.1rc1-20110826-1.patch.gz.sha256sum)
* [GitHub fork of CyanogenMod/android_external_openvpn](https://github.com/s-zeid/android_external_openvpn_ipv6)
* [I had to rebase Gert's patch for OpenVPN 2.2.1.  Here it is.](https://uploads.s.zeid.me/openvpn-2.2.1-ipv6-20110825-1.patch.gz)
  * [SHA-256 sum](https://uploads.s.zeid.me/openvpn-2.2.1-ipv6-20110825-1.patch.gz.sha256sum)

Enjoy!
<span style="background-color: #ff0; color: #000;">
 <strong>
  I will not provide support for any of this, so use it at your own risk and
  don't come crying to me if it hacks your Facebook and changes your relationship
  status or something.  I <em>really</em> can't help you with <em>that</em>.  :P
 </strong>
</span>
