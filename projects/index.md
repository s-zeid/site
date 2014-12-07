---
layout: misc
title: Projects
nav:
 sort-key: /aaa/projects
stylus: |
 main article nav
  margin-top: 0.5em;
  ul
   display: table;
   margin: 0;
   padding-left: 0;
   > li
    display: table-row-group;
    list-style: none;
    > a, > p
     display: table-row;
     > span
      display: table-cell;
      vertical-align: middle;
    > a
     line-height: 2em;
     font-weight: bold;
     img
      margin-right: 0.5em;
      for type in min max
       for dim in width height
        {type}-{dim}: 16px;
      @media (min-resolution: 160dpi),
             handheld, (max-width: 480px), (max-device-width: 480px)
       for type in min max
        for dim in width height
         {type}-{dim}: 22px;
    &:not(:last-child) > p
     > span
      padding-bottom: 0.5em;
---

Some projects of mine.  There's more on
[my Bitbucket profile](http://code.s.zeid.me/).

<nav>
 {% sitenav page.url %}{% raw %}
 <ul>
 {% for p in nav.pages %}
  {% capture li %}
  <li class="{%if p.nav.current%} current{%elsif p.nav.parent%} parent{%endif%}{%if p.title == "Home"%} home{%endif%}{%if p.nav.has_children%} has-children{%endif%}">
  {% endcapture %}
  {{ li | replace: 'class=" ', 'class="' | replace: ' class=""', "" }}
   <a href="{%if p.nav.url%}{{p.nav.url|uri_escape}}{%else%}{%root%}{{p.nav.slug|uri_escape}}{%endif%}"{%if p.nav.target%} target="{{p.nav.target|xml_escape}}"{%endif%}>
    <span>{% if p.icon %}<img src="{% root %}{% if p.nav.dir != "/" %}{{ p.nav.dir | uri_escape }}{% endif %}/{{ p.icon | uri_escape }}" alt="" class="left" />{% endif %}</span>
   {% if p.menu-text %}
    <span>{{p.menu-text}}</span>
   {% elsif p.title != "Home" %}
    <span>{{p.nav.title}}</span>
   {% else %}
    <span>{{site.name}}</span>
   {% endif %}
   </a>
   <p>
    <span></span>
    <span>{% if p.description %}{{ p.description | xml_escape }}{% endif %}</span>
   </p>
  </li>
 {% endfor %}
 </ul>
 {% endraw %}{% endsitenav %}
</nav>
