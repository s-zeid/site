---
layout: page
title: LastGraph poster
stylus: |
 .enlarge-hint
  display: none;
 #graph-figure
  max-width: 100%;
  margin: 0;
  img
   max-width: none;
 #graph-scrollbox
  max-width: 100%; min-height: 425px;
  overflow-x: auto;
  direction: rtl;
 #graph-header
  position: absolute;
  width: auto; height: auto;
  overflow: hidden;
  background: #fff;
  
 @media print
  .enlarge-hint
   display: none;
  #graph-figure
   overflow: visible;
   img
    max-width: 100%;
  #graph-scrollbox
   overflow-x: visible;
   min-height: 0;
  #graph-header
   display: none;
---
<?php

$mtime = filemtime(__DIR__."/graph.svg");

?><p>
 Here's a <a href="http://lastgraph.aeracode.org/" target="_blank">LastGraph</a>
 poster of my music listening trends in the past year:&nbsp;
 <span class="enlarge-hint-always-shown">(click/tap to enlarge)</span>
</p>

<figure id="graph-figure">
 <div id="graph-header">
  <a href="large/"><img src="header.svg" alt="" /></a>
 </div>
 <div id="graph-scrollbox">
  <a href="large/"><img id="graph" src="graph.svg" alt="" /></a>
 </div>
 <span style="font-size: small;">
  Last updated on
  <time datetime="<?php echo strftime("%Y-%m-%dT%H:%M:%S%z", $mtime); ?>"><?php
   echo strftime("%Y-%m-%d", $mtime);
  ?></time>.<span class="svg-hint">&nbsp; 
   Your browser must support SVG images in order to see the graph.
  </span>
 </span>
</figure>

<p>
 <a href="https://www.last.fm/user/s-zeid">My Last.fm profile</a>
 <span class="fill-in-last-fm-status hide"> &mdash; </span>
</p>

<script type="text/javascript">
 $("#graph").load(function() { $(".svg-hint").hide(); });
</script>
