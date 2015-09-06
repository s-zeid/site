$.get($("html").attr("data-root") + "/more/?json", function(portal) {
 var showMinibarIcons = true;
 var showIndexIcons   = false;
 
 var more = $("body > header nav [href$='//more.s.zeid.me/']").parent();
 var list = $("<ul></ul>").appendTo(more.addClass("has-children"));
 var highlightedEl = null;
 $.each(portal.sites, function(slug, site) {
  if ((showIndexIcons   || site.index   !== false) &&
      (showMinibarIcons || site.minibar !== false))  {
   var a = $("<a target='_blank'><span></span><span></span></a>");
   var desc_plain = $("<div></div>").html(site.desc).text();
   a.attr("href", site.url).attr("title", desc_plain);
   if (site.icon.small) {
    var icon = $("<img alt='' />").attr("src", site.icon.small);
    a.children().first().append(icon);
   }
   a.children().last().html(site.name);
   var li = $("<li></li>");
   li.append(a).appendTo(list);
   var highlightSlug = null;
   if (SITENAV_PAGE_INFO.nav.highlight) {
    highlightSlug = SITENAV_PAGE_INFO.nav.highlight.match(/\/more\/+([^\/]+)\/*$/);
    if (highlightSlug)
     highlightSlug = highlightSlug[1];
   }
   if (site.url.replace(/https?:/gi, "") == "//"+document.location.hostname+"/") {
    if (!highlightedEl)
     highlightedEl = li.addClass("current");
   }
   if (highlightSlug && highlightSlug === slug) {
    if (highlightedEl)
     highlightedEl.removeClass("current").removeClass("parent");
    highlightedEl = li;
    if (SITENAV_PAGE_INFO.nav["highlight-as-current"])
     li.addClass("current");
    else
     li.addClass("parent"); 
   }
  }
 });
 $(".fill-in-last-fm-status").append((function() {
  var span = $("<span></span>");
  var a = $("<a href='' target='_blank'></a>");
  var text = portal.sites["last.fm"].desc;
  text.replace(/^([^:]+)(:(&nbsp;|\s)+)(.*)$/, function(match, prefix, sep, _, song) {
   song = $("<span></span>").html(song).text();
   span.html(prefix + sep);
   a.html(song);
   a.attr("href", "https://duckduckgo.com/?q=" + encodeURIComponent(song));
   return "";
  });
  return span.append(a);
 })()).removeClass("hide").show();
}, "json");
