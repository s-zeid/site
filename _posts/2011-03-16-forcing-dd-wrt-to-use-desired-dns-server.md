--- 
layout: post
title:  Forcing DD-WRT to use the desired DNS server
date:   2011-03-16 22:39:26Z
tags:   rant
---

I should NOT have to add

    server=74.82.42.42
    no-resolv

to my DNSMasq config in DD-WRT in order for it to use the DNS server I want it to
and NOT my ISP's DNS servers with their lack of IPv6 Google and spamming queries
for non-existent domains.  And yes, I did set the DNS server on the main setup page.
