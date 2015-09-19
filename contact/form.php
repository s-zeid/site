<?php

$to             = "";
$subject_prefix = "";
$max_file_size  = 0;
$max_body_size  = 0;

require("config.php");   // hidden from directory listing

$result = array();
$show_form = false;
$coppa_checked = ($_POST["coppa"] == 1) ? ' checked="checked"' : "";

require("super-mailer-bros.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if (!$coppa_checked) {
?>
<p>
 <strong>
  You must be at least 13 years old to use this contact form.&nbsp;
 </strong>
 (<a href="https://en.wikipedia.org/wiki/COPPA" target="_blank">Why?</a>)
</p>
<?php
 } else {
  
  $subject = ($_POST["subject"]) ? $subject_prefix.$_POST["subject"] : "";
  
  $result = super_mailer_bros(
   $_POST["name"], $_POST["email"], $send_from, $to,
   $subject, $_POST["message"], $_FILES,
   $max_file_size, $max_body_size
  );
  
  if ($result === true) {
?>
<p>Thank you.&nbsp; I'll get back to you as soon as I can.</p>
<?php
  } else if ($result === false) {
?>
<p>
 Sorry, but there was a problem sending your message.  Please try again
 later.
</p>
<?php
  } else {
   $show_form = true;
  }
 }
} else {
 $show_form = true;
}

?>
