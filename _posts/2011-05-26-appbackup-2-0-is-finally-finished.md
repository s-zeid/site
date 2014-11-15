--- 
layout: post
title:  AppBackup 2.0 is finally finished!
date:   2011-05-26 12:06:06Z
categories: 
 - AppBackup
---

After a long wait, the new version of [AppBackup]({% dotdot %}/projects/appbackup/)
**AppBackup 2.0**, is finished and has been submitted to BigBoss.  It will show up
on Cydia within a day.  Here is what has changed in 2.0:

 * **AppBackup now works on iOS versions 4.3.x and later** (and it still works with
   iOS 3; untested on iOS 2).
 * Added a confirmation screen for all actions.
 * Redesigned About screen.
 * AppBackup has been split into two parts:
   * The GUI, written in Objective-C this time.
   * A command-line interface in the form of a Python package.  (Just type
     `appbackup` at the terminal to use it.)
   * As a result, the code has been completely rewritten and is much cleaner and
     object-oriented.
 * The FixPermissions utility can now be used by typing appbackup-fix-permissions at
   the terminal.  It is still run automatically in the GUI mode only.
 * Updated translations and added new translations for the following languages:
   * Czech - Jan Kozánek
   * Chinese - goodlook8666
   * Greek - Spiros Chistoforos-Libanis
   * Japanese - Osamu
   * Korean - Joon Ki Hong
   * Norwegian - Jan Gerhard Schøpp
 * Changed translations format in the source tree.
 * Translations are now managed on [Transifex](https://www.transifex.net/)
   (https://www.transifex.net/) and converted to Apple's Localizable.strings format
   at build time.

I would like to thank everyone who has been patient while I was working on fixing
AppBackup, and I am very sorry it took so long.
