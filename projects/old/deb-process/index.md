--- 
layout: page
title: deb-process
---

This takes one or more .deb files and makes info pages based on their control
files.&nbsp; The format of the info pages is defined by a template.

## [Download](http://uploads.srwz.us/deb-process.zip)

## Usage

    Usage: deb-process.py [options] DEB
    where DEB is the package to process if --all/-a is not enabled,
    or the directory whose packages to process if it is enabled.
    
    Takes a debian package and makes info files based on it
    
    Options:
      -h, --help            show this help message and exit
      -a, --all             process all debs in the current working directory.  If
			    this is not enabled, you must specify a DEB (.deb
			    file) to process.  If it is, DEB can be a directory
			    where the debs are.
      -o OUTPUT, --output=OUTPUT
			    directory to save the resulting files to to.  Defaults
			    to files/ in the script's directory.
      -t TEMPLATE_PATH, --template-path=TEMPLATE_PATH
			    directory where your templates are located.  Defaults
			    to templates/ in the script's directory.
