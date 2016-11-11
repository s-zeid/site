---
layout: page
title: Projects on GitLab
icon: icon.png
show-recent-posts: True
use-absolute-root: True
nav:
 url: https://code.s.zeid.me/
 sort-key: /projects/zzz/code
description: >
 There's much more on my GitLab profile.
---

<?php

// If you use this, see update.php for information about configuring your
// GitLab username and access token.

require("update.php");

?><p>
 These are my personal projects from
 <a href="https://gitlab.com/<?=$user_esc?>">my GitLab profile</a>.
</p>

<?php

libxml_disable_entity_loader(true);

if (!is_file($cache))
 update();
elseif (time() >= filemtime($cache) + 90) {
 touch($cache);
 $atom = simplexml_load_string(file_get_contents("https://gitlab.com/$user.atom"));
 if (isset($atom->updated)) {
  if (strtotime($atom->updated) > filemtime($cache))
   update();
 }
}

$projects = json_decode(file_get_contents($cache), true);

?><nav class="subpage">
 <ul>
<?php foreach ($projects as $p):
?>  <li>
   <span>
    <a href="https://code.s.zeid.me/<?=$p["%path"]?>"></a>
    <a href="https://code.s.zeid.me/<?=$p["%path"]?>"><?=$p["%name"]?></a>
   </span>
<?php if ($p["description"]):
?>   <p>
    <span></span>
    <span>
     <span><?=$p["%description"]?></span>
     <time datetime="<?=$p["updated"]?>">Last updated: <?=$p["updated_display"]?></time>
    </span>
   </p>
<?php endif;
?>  </li>
<?php endforeach;
?> </ul>
</nav>
