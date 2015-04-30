{$ template $}
---
layout: page
title:  Red Green Episodes
contents:
{$ contents $}
stylus: |
 @import "../../_config"  //_
 h3
  text-transform: none;
  letter-spacing: normal;
 h2, h3
  a[href^="#"]
   float: right;
   letter-spacing: normal;
   opacity: 0.125;
   color: $text-lighter;
   &:hover
    opacity: 1;
    color: $links;
---

This is the list of episodes of [The Red Green Show][wp], taken from
[an old version of the show's Web site][archive].  This list includes
summaries of each episode.

There are some more detailed lists on [Ninewords][ninewords] and
[TV.com][tv.com].

I appear in the lodge meeting in [episode 288, "New Yorkshire Puddings"][288].
(I'm on the front row, right hand side from the camera's point of view,
 second from the aisle.)

[wp]:        https://en.wikipedia.org/wiki/The_Red_Green_Show
[archive]:   https://web.archive.org/web/20121022134055/http://www.redgreen.com/episodes.htm
[ninewords]: http://ninewords.com/Fun/The%20Red%20Green%20Show/The%20Red%20Green%20Show.html
[tv.com]:    http://www.tv.com/shows/the-red-green-show/trivia/
[288]:       #episode-288


{$ episodes $}
