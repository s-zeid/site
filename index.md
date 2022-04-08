---
layout: page
title:  Home
icon:   favicon.png
contents:
 Tech:                tech
 Coding:              coding
 Music:               music
 About this Web site: site
description: >
 I am a sometimes penguin in Dallas, Texas.
stylus: |
 #music + ul a[href*="ericwhitacre.com"] ~ a  //*
  display: inline-block;
head: |
 <script type="text/javascript">
  /* Collapse extra whitespace in link tooltips in the main article */
  $(document).ready(function() {
   $("main > article a[title]").attr("title", function(i, value) {
    return value.replace(/[\n\t ]+/g, " ");
   });
  });
 </script>

---

I am a sometimes penguin in Dallas, Texas.


## Tech

* Linux, [postmarketOS](https://postmarketos.org/) on
  [PinePhone](https://www.pine64.org/pinephone/), Firefox
* [Anti-Apple](https://en.wikipedia.org/wiki/Criticism_of_Apple){:
   title="''Those who would give up essential Liberty, to purchase a little
          temporary Safety, deserve neither Liberty nor Safety.''
                                                    —Benjamin Franklin"}
* I believe in [free software](https://en.wikipedia.org/wiki/Free_software)
  and prefer to use it when possible.
* If necessary, I use virtual machines (using QEMU/KVM) to run software that
  is not available for Linux.
* Games I like include SuperTux, Minecraft, Minetest, SNES Yoshi's Island,
  Super Mario Sunshine, and Super Mario 64.


## Coding

* Python, [portable shell][], HTML 5/CSS 3, JavaScript, PHP, some Rust,
  some Ruby, Objective-C (kinda), *a little* C/C++
* Vim ([rc](https://s.zeid.me/vimrc))
* I indent with one space.
* [Projects on GitLab](https://code.s.zeid.me/)

[portable shell]: https://www.gnu.org/software/autoconf/manual/html_node/Portable-Shell.html


## Music

* Current favorites: 
  [Ludovico Einaudi][]{: title="Four Dimensions is the best element!"};
  Irish/Celtic music, including
  [Anúna][],
  [Solas][]{: title="my favorite band since I was 10"}
  and [Lúnasa][]{: title="Kevin Crawford gave me a free CD!"};
  [Antje Duvekot][Antje]{:
   title="One of her first songs, ''The Poisonjester's Mask'', ironically got me
          into Irish music when I was 10 and I heard Solas cover it.  It remains
          one of my favorite songs of all time."};
  Ewan MacColl; Nils Frahm; and Ludovico Einaudi.
* I sing second bass and I have participated in [Eric Whitacre's Virtual Choir][EWVC]:
  versions [2.0 ("Sleep")][VC2], [3 ("Water Night")][VC3], and
  [4 ("Fly to Paradise")][VC4].  I'm not currently in a choir.
* Did I mention I like Ludovico Einaudi's music?

[Ludovico Einaudi]: https://www.youtube.com/watch?v=caxZFKKcyGU "Four Dimensions"
[Anúna]:            https://www.anuna.ie/
[Solas]:            https://en.wikipedia.org/wiki/Solas_(group)
[Lúnasa]:           https://www.lunasamusic.com/
[Antje]:            https://antjeduvekot.com/
[EWVC]:             https://ericwhitacre.com/the-virtual-choir
[VC2]:              https://www.youtube.com/watch?v=6WhWDCw3Mng
[VC3]:              https://www.youtube.com/watch?v=V3rRaL-Czxw
[VC4]:              https://www.youtube.com/watch?v=Y8oDnUga0JU


## About this Web site {#site}

* Uses [Jekyll](https://github.com/jekyll/jekyll),
  [Stylus](https://learnboost.github.io/stylus/),
  GNU `make`, and a little bit of PHP (for
  [blog comments](https://code.s.zeid.me/freecomment),
  [the contact form](https://code.s.zeid.me/site/src/main/contact/), and
  [redirecting](https://code.s.zeid.me/site-design/src/main/static/redirect.php)
  [old URLs](https://code.s.zeid.me/site/src/main/_redirects)).  Edited in Vim. 
  [See the source here.](https://code.s.zeid.me/site/src)
* Designed by me.  Supports all modern Web browsers (including mobile) and
  IE 8 (older versions of IE get the color scheme and fonts and that's it). 
  Uses responsive design.
* The design is maintained separately in
  [its own Git repository](https://code.s.zeid.me/site-design).
* Hosted on a VPS running [Alpine Linux](https://alpinelinux.org/) at
  [Hetzner](https://www.hetzner.com/cloud) in Ashburn, Virginia.
* [Let's Encrypt!](https://letsencrypt.org/)
* The owner of this Web site is a Ludovico Einaudi fan.
* `2a01:4ff:f0:11e5::``b49e`, `5.161.58.124`, [dns.he.net](https://dns.he.net/)
