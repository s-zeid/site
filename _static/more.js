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
 $(".fill-in-last-fm-status").append(
  $("<span></span>").html(portal.sites["last.fm"].desc)
 ).show();
}, "json");
