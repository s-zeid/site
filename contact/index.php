---
layout: page
title: Contact
nav:
 sort-key: /yyy/contact
---

<?php

require("form.php");

if ($show_form) {
?>

<a id="form"></a>

<blockquote>
 <strong>
  <a href="{% root %}/projects/appbackup/#ios-8-notice">
   AppBackup does not currently work on iOS 8.  Click here for more information.
  </a>
 </strong>
</blockquote>

<p>If you're contacting me about a different problem with
 <a href="{% root %}/projects/appbackup/">AppBackup</a>,
 please attach the last crash log file from the
 <code>/var/mobile/Library/Logs/CrashReporter</code> folder that starts with
 <strong>AppBackupGUI_</strong>, if there is one.
</p>

<p>All fields except the attachments field are required.</p>

<form action="{% root %}/contact/" method="post"
      enctype="multipart/form-data">
 <section>
  <label for="name">Name</label>
  <input type="text" name="name" value="<?php echo smb_esc($_POST["name"]); ?>" />
  <?php if (in_array("from_name", $result)) { ?>
   <p><strong>Please enter your name.</strong></p>
  <?php } ?>
 </section>
 <section>
  <label for="email">Email address</label>
  <input type="text" name="email" value="<?php echo smb_esc($_POST["email"]); ?>" />
  <?php if (in_array("from_email", $result)) { ?>
   <p><strong>Please enter your email address.</strong></p>
  <?php } ?>
 </section>
 <section>
  <label for="subject">Subject</label>
  <select name="subject">
   <option value="">(Choose a subject)</option>
   <option value="AppBackup problem">AppBackup problem</option>
   <option value="AppBackup translation question">
    AppBackup translation question
   </option>
   <option value="AppBackup">AppBackup (other)</option>
   <option value="Other project">Other project</option>
   <option value="Security issue">Security issue</option>
   <option value="Personal information">Personal information</option>
   <option value="General">General</option>
  </select>
  <?php if (in_array("subject", $result)) { ?>
   <p><strong>Please choose a subject.</strong></p>
  <?php } ?>
  <script type="text/javascript">
   var subject = "<?php echo str_replace('"', '\\"', $_POST["subject"]); ?>";
   $("select[name='subject'] option").each(function(i, o) {
    if (o.value == subject) o.selected = true;
   });
  </script>
 </section>
 <section>
  <label for="message">Message</label>
  <textarea name="message"><?php echo smb_esc($_POST["message"]); ?></textarea>
  <?php if (in_array("message", $result)) { ?>
   <p><strong>Please enter a message.</strong></p>
  <?php } ?>
 </section>
 <section>
  <label>Attachments</label>
  <p style="font-size: smaller; max-width: 30.8em;">
   You may attach up to three files.&nbsp;
   Each must be no larger than 16 MB, and the total size of all files
   must be no greater than 24 MB.
  </p>
  <div><input type="file" name="attachment-1" /></div>
  <div><input type="file" name="attachment-2" /></div>
  <div><input type="file" name="attachment-3" /></div>
  <?php if (in_array("file_size", $result) ||
            in_array("body_size", $result)) { ?>
   <p><strong>Please check the sizes of your attachments.</strong></p>
  <?php } ?>
 </section>
 <section>
  <span></span>
  <input type="checkbox" name="gdpr-age" id="gdpr-age" value="1"<?php
   echo $gdpr_age_checked; ?> />
  <label for="gdpr-age">
   I am at least 16 years of age.
   (<a href="https://gdpr-info.eu/art-8-gdpr/" target="_blank">Why?</a>)
  </label>
 </section>
 <section>
  <span></span>
  <input type="checkbox" name="consent" id="consent" value="1"<?php
   echo $consent_checked; ?> />
  <label for="consent">
   I understand <a href="{% root %}/legal/privacy-policy/">the privacy
   policy</a>, and I consent to you using my information to receive and answer
   my message and for other reasons listed in the privacy policy.
  </label>
  <?php if (in_array("consent", $result)) { ?>
   <p><strong>
    You need to consent before I can receive your message or do
    anything with it.  Please read <a href="{% root %}/legal/privacy-policy/">the
    privacy policy</a> before consenting.
   </strong></p>
  <?php } ?>
 </section>
 <section>
  <span></span>
  <input type="submit" name="submit" value="Send message" />
 </section>
 <section>
  <span></span>
  <p style="font-size: smaller; max-width: 30.8em;">
   <em>
    Powered by
    <a href="https://code.s.zeid.me/site/src/master/contact/super-mailer-bros.php"
     >Super Mailer Bros. 3</a>.
   </em>
  </p>
 </section>
</form>
<?php } ?>
