---
layout: page
title:  Syntax Highlighting Test
---

{% highlight lua %}{% raw %}
-- (c) 2012-2014 S. Zeid.  X11 License.  Uses Pygments.
-- <https://s.zeid.me/.highlight.lua>
-- <https://s.zeid.me/.highlight.lua;highlight>
-- 
-- Yes, I know my code is shit.  Please send bugs to <s AT zeid DOT me>.
-- 
-- Here's how I deploy it in my lighttpd.conf
-- (with "mod_magnet" in server.modules):
-- 
--     # Source highlighting {{{1
--     var.highlight-script = "/etc/lighttpd/static/highlight.lua"
--     $HTTP["url"] =~ "^/(.*\.(php[345]?|phtml));hl$" {
--      # no PHP highlighting unless the extension is phps
--     }
--     else $HTTP["url"] =~ "^/(.*)(;hl|;highlight|\.phps)$" {
--      magnet.attract-physical-path-to = ( var.highlight-script )
--     }
--     else $HTTP["url"] == "/.highlight.lua" {
--      # "/.highlight.lua" should be equal to the `self` variable in the script
--      alias.url = ( "/.highlight.lua" => var.highlight-script )
--      mimetype.assign = ( ".lua" => "text/plain; charset=utf-8" )
--     }

self = "/.highlight.lua"

function basename(s)
 -- strip trailing slashes then directory parts
 return s:gsub("/*$", ""):gsub("([^/]*/)", "")
end
function dirname(s)
 -- strip trailing slashes, then excess slashes, then last component,
 -- then special-case the root directory
 return s:gsub("/*$", ""):gsub("//*", "/"):gsub("/[^/]$", ""):gsub("^$", "/")
end
function escape_shell_arg(s)
 return "'"..s:gsub("'", "'\\''").."'"
end
function html_special_chars(s)
 local specials={}
 specials["<"] = "&lt;"
 specials[">"] = "&gt;"
 specials["&"] = "&amp;"
 specials['"'] = "&quot;"
 specials["'"] = "&#x27;"
 return s:gsub("([<>&\"'])", specials)
end
function source_file()
 r = debug.getinfo(1).source
 return r:match("^@") and r:gsub("^@", "") or nil
end

path = lighty.env["physical.path"]
file = path:gsub(";hl$", ""):gsub(";highlight", "")
base = basename(file)

if file == lighty.env["physical.doc-root"]..self and source_file() then
 path = source_file()
 file = path:gsub(";hl$", ""):gsub(";highlight", "")
 base = basename(file)
end

should_highlight = not (path ~= file and lighty.stat(path))

if should_highlight then
 -- Note:  Percent signs in cmt, css, or fnt should be escaped ("%%").
 cmt =      "The source for the highlighter is available at"
 cmt = cmt.."\n<https://s.zeid.me/.highlight.lua> (and highlighted at"
 cmt = cmt.."\n<https://s.zeid.me/.highlight.lua;highlight>)."
 cmt = cmt.."\nIt is released under the X11 License."
 cmt = cmt.."\n"
 cmt = cmt.."\nUses Pygments.  Yes, I know the code for it is shit."
 cmt = cmt.."\nPlease send bugs to <s AT zeid DOT me>."
 css =      "body { margin-top: -.6em; margin-bottom: -.6em; }\nh2 { display: none; }"
 css = css.."\ntd.linenos, span.lineno { background: transparent; color: #aaaaaa; }"
 css = css.."\ntd.linenos a, span.lineno a { color: #aaaaaa; text-decoration: none; }"
 fnt =      '@import url("https://fonts.googleapis.com/css?family='
 fnt = fnt..'Ubuntu+Mono:normal,italic,bold,bolditalic");'
 fnt = fnt.."\n"..'* { font: 10.5pt "Ubuntu Mono", "Droid Sans Mono", "DejaVu Sans Mono",'
 fnt = fnt..' "Consolas", "Courier New", "Courier", monospace; }'
 
 cmd =      "pygmentize -f html -O encoding=guess,outencoding=utf-8"
 cmd = cmd.." -O full,nobackground,linenos,anchorlinenos,lineanchors=line,linespans=line"
 cmd = cmd.." -P title="..escape_shell_arg(base)
 if path:match("[.](php[s]?)$") or path:match("[.](phtml)$") then
  cmd = cmd.." -l html+php" end
 if path:match("[.](svg)$") then
  cmd = cmd.." -l xml" end
 cmd = cmd.." "..escape_shell_arg(file)
 
 p = io.popen(cmd.."; printf '%s' $?", "r")
 lines = {}
 for line in p:lines() do
  table.insert(lines, line)
 end
 p:close()
 
 r = table.remove(lines)
 out = table.concat(lines, "\n")
 
 if r == "0" then
  lighty.header["Content-Type"] = "text/html; charset=utf-8"
  out = out:gsub("<html>", "<!--\n\n"..cmt.."\n\n-->")
  out = out:gsub("( *)</style>", "/* Custom styles */\n"..css.."\n%1</style>\n%1<style type=\"text/css\">\n"..fnt.."\n%1</style>")
  lighty.content = {out}
  return 200
 else
  lighty.header["Content-Type"] = "text/html; charset=utf-8"
  out_esc = html_special_chars(out)
  cmd_esc = html_special_chars(cmd)
  err =      "<h1>500 Internal Server Error</h1>"
  err = err.."<p>The file or directory you requested could not be highlighted.</p>\n";
  err = err.."<h2>Details:</h2>\n";
  err = err.."<strong>Command:</strong>&nbsp; <pre style=\"display: inline;\">"..cmd_esc.."</pre>";
  err = err.."<pre>"..out_esc.."</pre>\n";
  err = err.."<p style=\"font-size: small;\">(Exit code "..r..")</p>";
  lighty.content = {err}
  return 500
 end
end 
{% endraw %}{% endhighlight %}
