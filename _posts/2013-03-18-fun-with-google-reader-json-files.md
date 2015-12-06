---
layout: post
title:  Fun with Google Reader JSON files
date:   2013-03-18 20:49
---

So if you haven't heard already, [Google Reader is shutting down on July 1, 2013][notice]. 
However, until then, you can [take your data out using Google Takeout][Takeout]
and you'll have all your subscriptions and starred, liked, and shared articles. 
The problem is that the article lists are JSON files with a custom schema that
there aren't (as far as I know) any user-friendly parsers for, so I made one.

[Stella][Stella] runs entirely in your modern, standards-compliant, [HTML5
FileReader API][FileReader]-supporting Web browser (you are using [one][Firefox],
right?) and lets you view any Google Reader article list in JSON format, including
your starred, liked, shared, and notes lists, as well as any subscriptions you've
exported in JSON format (more on that in a minute).  All you have to do is click
"Select JSON file", select your file, and start reading!

Stella also lets you save a static HTML page which you can view offline.  The page
will also contain an exact copy of the JSON file you selected (with HTML special
characters escaped).  (Clicking "Static page" will only give you a Save As screen
in a few browsers, notably Chrome 14+ and Firefox 20+.  Other browsers will show
the static page in a new tab, and you'll need to right-click the link or page
and choose "Save Page/Link As" to save it.  Also, saving static pages will only
work at all in [browsers that support the Blob API][Blob] (look under "`Blob()`
constructor").)

It's worth noting that Google Reader JSON files *do* contain the full contents of
each article, and Stella does let you view those.

[The source code to Stella is available on GitLab][Stella-repo] and is released
under the X11 License.  If you modify the JavaScript or CSS files, run `make` to
regenerate the `stella.combined.{js,css}` files; otherwise, you won't see your
changes.

### Exporting feeds (or folders) as JSON files   {#exporting-feeds-as-json-files}

[(Permalink to this section)]({{site.full-url}}{{page.url}}#exporting-feeds-as-json-files) 
Now, I mentioned earlier that you can export your subscriptions as JSON files as
well.  This also exports the article contents.  **This is insanely useful as
Google Reader keeps an archive of *EVERY ARTICLE EVER POSTED IN THE FEED*, even
if they were posted after you subscribed to the feed (but after at least one
person has done so), even for feeds that have since been removed by their
publishers.**  This is one thing that I've really loved about Google
Reader, and I'm thrilled to learn that you can export every article ever posted
in a feed that has been subscribed to in Google Reader.  Oh, and it works for
folders, too!

To export a feed or folder as a Google Reader JSON file:

1. Open the subscription in Google Reader.
2. In the URL in your browser's location bar, replace "`/view/#stream/`"
   with "`/api/0/stream/contents/`". So, for example,
   
       https://www.google.com/reader/view/#stream/feed%2Fhttp%3A%2F%2Fxkcd.com%2Frss.xml
   
   would become  
   
       https://www.google.com/reader/api/0/stream/contents/feed%2Fhttp%3A%2F%2Fxkcd.com%2Frss.xml
   
3. Add `?n=999999999` to the end of the new URL.  If you skip this step, it would
   only give you the first 20 or so articles in the feed, although it appears that
   there's still a limit of one thousand articles.  If your feed has more than
   999,999,999 articles (which would be insanely unlikely), you would want to
   increase that number.
4. Hit `Alt`+`Enter` to open the JSON file in a new tab.  From here, you can
   right-click and choose "Save Page As" to save it, but be sure to give it
   a filename that ends in "`.json`".
5. (Optional) Open the file in [Stella][Stella]!

I cannot stress enough that if you want to do this, and/or export your starred,
saved, shared, and notes lists, **you MUST do it before July 1, 2013**, as that
is the date that Google Reader shuts down.




[notice]:      http://googlereader.blogspot.com/2013/03/powering-down-google-reader.html
[Takeout]:     https://goo.gl/zijsh
[Stella]:      https://stella.s.zeid.me/
[Stella-repo]: https://code.s.zeid.me/stella
[FileReader]:  https://developer.mozilla.org/en-US/docs/DOM/FileReader
[Firefox]:     https://www.mozilla.org/en-US/firefox/fx/
[Blob]:        https://developer.mozilla.org/en-US/docs/DOM/Blob#Browser_compatibility
