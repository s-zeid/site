---
layout: page
title: set-wallpapers-dualhead
---

*Set Wallpapers for Dual-Head Monitor Setup*

This script is intended for people who use a dual-head monitor setup on a
Linux computer running Gnome who want to set up different wallpapers.&nbsp;
Gnome has no built-in way of doing this, so I wrote a script to do it.

**Note:**&nbsp;  I only tested this in the setup from the example below.&nbsp;
It should work for other setups, as long as the first screen is at the left or
the top.

Although it should be run from the command line, it uses GTK+ dialogs for file
selection.&nbsp; Here's the syntax:

    $ set-wallpapers-dualhead (first screen size) (second screen size) (horizontal | vertical)

For example, if you have two heads, one 1440x900 and one 1280x1024, and they are
positioned horizontally (i.e. left-to-right), you'd run:

    $ set-wallpapers-dualhead 1440x900 1280x1024 horizontal

Two file selection dialogs will appear, one for each wallpaper.&nbsp; Then, the
script will scale them to fit your monitors, combine them into one image file,
and set that file as your wallpaper.

## [Download](https://uploads.s.zeid.me/script/set-wallpapers-dualhead)

## Requirements

* PHP 5 command-line interface
* ImageMagick
* Zenity

These can be installed on Ubuntu and other Debian-based distros using:

    $ sudo apt-get install php5-cli imagemagick zenity
