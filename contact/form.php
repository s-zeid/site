<?php

$to             = "";
$subject_prefix = "";
$max_file_size  = 0;
$max_body_size  = 0;

require("config.php");   // hidden from directory listing

$result = array();
$show_form = false;
$gdpr_age_checked = ($_POST["gdpr-age"] == 1) ? ' checked="checked"' : "";
$consent_checked = ($_POST["consent"] == 1) ? ' checked="checked"' : "";

require("super-mailer-bros.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if (!$gdpr_age_checked) {
?>
<p>
 <strong>
  You must be at least 16 years old to use this contact form.&nbsp;
 </strong>
 (<a href="https://gdpr-info.eu/art-8-gdpr/" target="_blank">Why?</a>)
</p>
<?php
 } elseif (!$consent_checked) {
  $result[] = "consent";
  $show_form = true;
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
