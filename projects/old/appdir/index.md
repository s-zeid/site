--- 
layout: page
title: appdir
---

This is a simple Python script that outputs the absolute path of any installed
App Store app.

The reason I wrote this is because I found myself working with App Store apps on
the command line and I wanted a quick way to find out what directory the app is
stored in.

The problem is that each app is stored in `/var/mobile/Applications/(a random GUID)`
and that GUID says nothing about the app itself.&nbsp; This script works by
iterating through each of these directories and finding out which one, if any,
has a subdirectory for the app in question.

## [Download](http://uploads.srwz.us/script/appdir)

## Requirements

* A jailbroken iPhone or iPod touch running iPhoneOS 2.0
* Python (available through Cydia)
* One or more App Store apps installed on your device

## Usage

* Copy the script into `/usr/bin` on your phone.&nbsp; (You'll need to log in
  as root first.)
* Run `appdir (name of app)`.&nbsp; You don't have to put the name of the app
  in quotes.

## Example

    $ appdir Monkey Ball.app

might give you:

    /var/mobile/Applications/505E55D8-B023-46BA-9D2B-D9935A7D7835

and

    $ ls `appdir Monkey Ball.app`/Monkey\ Ball.app

might return:

<pre><span style="color: #00ffff;"><strong>CodeResources</strong></span>  <span style="color: #0000ff;"><strong>Levels</strong></span>          ResourceRules.plist  <strong><span style="color: #0000ff;">TexturePackages</span></strong>
Default.png    MainWindow.nib  <strong><span style="color: #0000ff;">SC_Info</span></strong>              <strong><span style="color: #0000ff;">XML</span></strong>
Icon.png       <span style="color: #00ff00;"><strong>Monkey Ball</strong></span>     <strong><span style="color: #0000ff;">SFX</span></strong>                  <strong><span style="color: #0000ff;">_CodeSignature</span></strong>
Info.plist     <strong><span style="color: #0000ff;">Music</span></strong>           <strong><span style="color: #0000ff;">Sprite</span></strong>               <span style="color: #000000;">replay.bin</span>
<strong><span style="color: #0000ff;">Level_Objects</span></strong>  PkgInfo         <strong><span style="color: #0000ff;">Text</span></strong>
</pre>

Putting a command in &#x60;'s means that the command is replaced with its
output&mdash;in this case, the path to the app's directory.&nbsp; So, that
command becomes:

    ls /var/mobile/Applications/505E55D8-B023-46BA-9D2B-D9935A7D7835/Monkey\ Ball.app
