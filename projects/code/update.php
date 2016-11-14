<?php

// If you use this, your GitLab username and access token should be in
// this file, which should have the format `<user>:<token>`.
$creds_path = "~/.gitlab-projects-list.creds";

$cache = __DIR__.DIRECTORY_SEPARATOR."projects.json";

load_creds();

function load_creds() {
 global $creds_path, $user, $user_esc, $token;
 if (substr($creds_path, 0, 2) === "~/" || substr($creds_path, 0, 2) === "~\\") {
  // expand home directory
  if (strtolower(substr(php_uname("s"), 0, 3)) !== "win")
   $home = getenv("HOME");
  else
   $home = getenv("USERPROFILE");
  $creds_path = $home.DIRECTORY_SEPARATOR.substr($creds_path, 2);
 }
 $creds = (is_file($creds_path)) ? trim(file_get_contents($creds_path)) : "";
 $creds = explode(":", $creds, 2);
 $user = $creds[0];
 $token = $creds[1];
 $user_esc = htmlentities($user, ENT_QUOTES, "UTF-8");
}

function update() {
 global $cache, $token;
 $url = "https://gitlab.com/api/v3/projects/owned?visibility=public&order_by=updated_at&per_page=100";
 $projects_json = [];
 $response = [];
 $page = 1;
 do {
  $ch = curl_init("$url&page=$page");
  curl_setopt($ch, CURLOPT_HTTPHEADER, ["PRIVATE-TOKEN: $token"]);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 16);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  if ($code >= 200 && $code < 400)
   $response = json_decode($response, true);
  else
   $response = [];
  $projects_json = array_merge($projects_json, $response);
  $page += 1;
 } while (count($response));
 
 $projects = [];
 foreach ($projects_json as $p) {
  if (!empty($p["forked_from_project"]))
   continue;
  if (empty($p["path"]) || empty($p["last_activity_at"]))
   continue;
  $updated = $p["last_activity_at"];
  $entry = [
   "name" => $p["name"],
   "description" => $p["description"],
   "path" => $p["path"],
   "updated" => $updated,
   "updated_display" => strftime("%Y-%m-%d %H:%M:%S", strtotime($updated)),
  ];
  // HTML-escape each value and store in array as `&<key>`
  foreach (array_keys($entry) as $k) {
   $entry["&$k"] = htmlentities($entry[$k], ENT_QUOTES, "UTF-8");
  }
  // linkify the HTML-escaped description
  $entry["&description"] = preg_replace_callback(
   "@(https?://[^\s\)\}\]]+)@i",
   function($m) {
    return "<a href=\"$m[0]\">$m[0]</a>";
   },
   $entry["&description"]
  );
  $projects[] = $entry;
 }
 
 if (!empty($projects))
  file_put_contents($cache, json_encode($projects, JSON_PRETTY_PRINT));
}
