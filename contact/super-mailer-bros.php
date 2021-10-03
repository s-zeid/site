<?php

/* Super Mailer Bros. 3
 * Copyright (c) 2012-2015, 2021 S. Zeid.  Released under the X11 License.
 * 
 * This isn't my best code, but here it is anyway.  It uses the Mail_Mime
 * PEAR package to generate the MIME message.  Previously, this used
 * imap_mail_compose() from the IMAP extension, which is no longer being
 * shipped by various distributions due to it using uw-imap, which has
 * been unmaintained for over a decade.  See:
 * 
 * - <https://bugzilla.redhat.com/show_bug.cgi?id=1933406#c1>
 * - <https://bugzilla.opensuse.org/show_bug.cgi?id=1089061#c18>
 * 
 * I know I could have used PHPMailer or something, but I wanted to do
 * it myself (aside from using Mail_Mime to generate the MIME message),
 * and besides, this comes out to be about 4 KB excluding comments
 * (~7 KB with comments), and it also has a funny name.
 * 
 * Requires a `file` command with the `--brief` and `--mime-type` (not
 * just `-i`) options, and PHP >= 5.1 with the Mail_Mime PEAR package
 * (`apt install php-mail-mime`, `dnf install php-pear-Mail-Mime`,
 * `apk add php8-pear php8-openssl && pear8 install Mail_Mime`).
 * 
 */


require_once("Mail/mime.php");


/* Most arguments are self-explanatory.
 * 
 * $send_from is the address to use in the From header.  If $from_email
 * is user-provided, then $send_from should be an address on a domain you
 * control in order to prevent messages from being eaten by hungry spam
 * filters, although you can set it to null to make it use the $from_email
 * address instead.  If $send_from contains a plus sign right before the at
 * sign, then a random hexadecimal number will be inserted between the plus
 * and at signs.  This prevents similar messages from different senders from
 * being grouped together in various threaded email clients.  $from_email,
 * $send_from, and $to should be plain email addresses
 * 
 * $uploads is an associative array of attachments in the same format as
 * $_FILES.  $max_body_size refers to the total size of the MIME body after
 * processing, right before mail() is called.
 * 
 * The message will include the user's IP address and email address at the
 * end, and the HTML version will have a link to a WHOIS lookup of the IP
 * address (currently using bgp.he.net).  The text "Sent by Super Mailer
 * Bros. 3" will also appear at the end of the message.
 * 
 * Returns true on success or false if mail() fails.  If one or more
 * arguments failed to validate, it returns an indexed array containing
 * the name(s) of the argument(s).  If an individual file exceeds
 * $max_file_size, the array will also contain "file_size", and if the
 * size of the MIME body exceeds $max_body_size, then the array will
 * contain *only* "body_size".  If $max_file_size is zero and any file
 * is attached, the array will contain "file_attached" instead of
 * "file_size".
 * 
 */
function super_mailer_bros($from_name, $from_email, $send_from, $to,
                           $subject, $message, $uploads=array(),
                           $max_file_size=0, $max_body_size=0) {
 $failed = array();
 $other_failure = false;
 $file_sizes_ok = true;
 $attachments = array();
 foreach ($uploads as $field => $file) {
  if ($file["tmp_name"]) {
   if ($max_file_size) {
    $file_sizes_ok = $file_sizes_ok && ($file["size"] <= $max_file_size);
   } else {
    $failed[] = "file_attached";
    $other_failure = true;
    break;
   }
   $filename = basename($file["name"]);
   $mime_type = smb_mime($file["tmp_name"]);
   $attachments[] = array(
    "type" => $mime_type,
    "name" => $filename,
    "data" => file_get_contents($file["tmp_name"]),
   );
  }
 }
 
 if (empty($send_from)) {
  $send_from = $from_email;
 } else if (strpos($send_from, "+@") !== false) {
  $random_part = dechex(rand(0x10000000, 0xffffffff));
  $send_from = str_replace("+@", "+$random_part@", $send_from);
 }
 
 if ($from_name && strpos($from_email, "@") !== false &&
     $subject && $message && $file_sizes_ok && !$other_failure) {
  $mime = new Mail_Mime(array(
   "text_charset" => "utf-8",
   "html_charset" => "utf-8",
  ));
  $headers = array(
   "From" => "$from_name <$send_from>",
   "Reply-To" => $from_email,
   "X-Mailer" => "Super Mailer Bros./3.0-bnay-6",
  );
  $content_array = array(
   "text" => ""
    ."$message\r\n\r\n"
    ."\r\n"
    ."--\r\n"
    ."Sent by Super Mailer Bros. 3\r\n"
    ."\r\n"
    ."Sender's email address:  $from_email\r\n"
    ."Sender's IP address:  {$_SERVER["REMOTE_ADDR"]}\r\n"
   ,
   "html" => ""
    ."<pre style='white-space: pre-wrap; font-family: inherit;'>"
    .  smb_esc($message)
    ."</pre>\r\n\r\n"
    ."\r\n<br />\r\n"
    ."<div style='opacity: 0.75;'>\r\n"
    ." <p>\r\n"
    ."  --<br />\r\n"
    ."  Sent by Super Mailer Bros. 3\r\n"
    ." </p>\r\n"
    ." <p>\r\n"
    ."  <strong>Sender's email address:</strong>&nbsp; \r\n"
    ."  <a href=\"mailto:".smb_esc($from_email)."\">\r\n"
    ."   ".smb_esc($from_email)."\r\n"
    ."  </a>\r\n"
    ."  <br />\r\n"
    ."  <strong>Sender's IP address:</strong>&nbsp; \r\n"
    ."  <a href=\"https://bgp.he.net/ip/{$_SERVER["REMOTE_ADDR"]}#_whois\">\r\n"
    ."   {$_SERVER["REMOTE_ADDR"]}\r\n"
    ."  </a>\r\n"
    ." </p>\r\n"
    ."</div>\r\n"
   ,
  );
  $mime->setTxtBody($content_array["text"]);
  $mime->setHTMLBody($content_array["html"]);
  if (count($attachments)) {
   foreach ($attachments as $attachment) {
    $mime->addAttachment(
     $attachment["data"],  // string $file
     $attachment["type"],  // string $c_type
     $attachment["name"],  // string $name
     false,  // boolean $isFile
     "base64",  // string $encoding
     "attachment",  // string $disposition
     "",  // string $charset
     "",  // string $language
     "",  // string $location (RFC 2557.4)
     null,  // string $n_encoding (Content-Type filename)
     null,  // string $f_encoding (Content-Disposition filename)
     $attachment["name"],  // string $description
     null,  // string $h_charset (headers)
    );
   }
  }
  $body = $mime->get(
   null,  // array $param
   null,  // resource $filename
   true,  // boolean $skip_head
  );
  $mail_headers = $mime->headers($headers);
  if ($max_body_size && strlen($body) > $max_body_size)
   return array("body_size");
  // when mail() uses sendmail (i.e. if we're not on Windoze) to send messages,
  // native line endings need to be used
  if (strtolower(substr(php_uname("s"), 0, 3)) !== "win")
   $body = str_replace("\r\n", PHP_EOL, $body);
  return mail($to, $subject, $body, $mail_headers);
 } else {
  $vars = explode(",","from_name,from_email,to,subject,message");
  foreach($vars as $var) {
   if (!$$var) $failed[] = $var;
  }
  if (!$file_sizes_ok)
   $failed[] = "file_size";
  if ($other_failure && !count($failed))
   $failed[] = "other";
  return $failed;
 }
}


function smb_esc($s) {
 return htmlentities($s, ENT_QUOTES, "UTF-8");
}


function smb_mime($f) {
 return trim(exec("file --brief --mime-type ".escapeshellarg($f)));
}

?>
