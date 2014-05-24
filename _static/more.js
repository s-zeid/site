$.get("/more/?json", function(portal) {
 var showMinibarIcons = true;
 var showIndexIcons   = false;
 
 var more = $("body > header nav [href$='//more.s.zeid.me/']").parent();
 var list = $("<ul></ul>").appendTo(more.addClass("has-children"));
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
   $("<li></li>").append(a).appendTo(list);
   if (site.url.replace(/https?:/gi, "") == "//"+document.location.hostname+"/")
    a.parent().addClass("current");
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
 })()).show();
}, "json");
