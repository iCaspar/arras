# Arras WordPress Theme

## Overview
Arras is a sophisticated, yet simple and clean WordPress theme for magazine/news blogs with the following features:

* Homepage comes with a featured slideshow and 3 featured post areas with 4 different customizable layouts.
* Comes with one-, two- and three-column layouts and 7 different alternate styles.
* WordPress 3.0-ready with two menu locations, custom post types and custom taxonomies support.
* Child theme ready with numerous action and filter hooks available for use.

## History
Arras was originally released as a Premium WordPress theme.
In 2009 it was released as a public project on GitHub by Lead Developer, Melvin Lee (@zyml).

Lee's team worked on the project from 2009 - 2012, and started a second project, AR2, that was released as Arras 2.0 in 2012.
The last commit was May 21, 2013, but a new version was never released.

As of May 1, 2014 the theme's website, http://www.arrastheme.com, announced that the developers were discontinuing the project, and releasing it to any interested parties for further development under the *GNU General Public License v2*. Inquiries were referred to a Google groups page (https://groups.google.com/forum/#!forum/arras-theme) for assistance, and to the project on Github.

## Resumed Development at iCaspar Web Development
As it happens, a few of my clients obtained the Arras theme several years ago. Though they like the theme, it has become increasingly unstable as WordPress has been updated but the theme has not. Left without support, (as were many others) I am accepting the former developer's (@zyml) invitation to resume development of the theme.

**iCaspar Web Development is undertaking this project as an open source project without any warrantee that development will continue, or that the results will be fit for use by anyone for any purpose. iCaspar Web Development is not affiliated with, nor do I have contact with, any previous developers of the Arras theme, nor have I received any payment or benefits from the former developers, other than the GNU licensed code itself.**

## Version 1.5.5
This version is the first re-release of the Arras Theme since restarting development from Arras 1.5.3-RC1. It includes all the features that were present in version 1.5.3.

The release focuses on fixing various javascript conflicts that have developed since the last release 2 years ago. Other unconventional loading of scripts has been cleaned up to minimize scripting conflict with plugins.

### Bug Fixes:
* Fix Admin bar search background css bug
* Fix wp_reset_query() issue in arras_document_description() - library/template.php
* Fix Sidebar registration to properly fire on wp_init - functions.php
* Remove unused actions and constants - functions.php
* Add initial content_width global - functions.php
* Fix js loading from all over. JS now loads via wp_enqueue_scripts()
* Eliminate outdated jQuery and use jQuery and migrate (1.11.0 / 1.2.1) packaged with WP
* Eliminate outdated jQuery HoverIntent and use r7 packaged with WP
* Remove outdated/unnecessary scripts (jQuery Validator and jQuery superslight)
* Fix tabbed sidebar widget script loading
* Add dynamic sizing to default thumbnail image

### Other Changes:
* Convert form input backgrounds from image to css3 gradient
* Move Arras Theme Admin Pages to an Appearance submenu
* Remove Donate Button from Admin sidebar
* Set "About Arras Theme" URL in footer to new website
* Update Superfish to latest version (1.7.4)

## Milestones and Priorities
My immediate priorities for development are:
1. Review code changes and issues on @zyml's AR2 repo (https://github.com/zyml/project-ar2).
2. Bring theme up to date with the current release of WordPress (Currently WP3.9, but realistically this may not happen until WordPress has gone 4.0).
3. Release a stable Arras 3.0 version.

Features proposed for implementation in future versions include:
* Conversion to HTML5/CSS3 (the previous developer did this in Arras 2.0. The redevelopment will follow a similar track to maintain as much consistency as possible.)
* Make search bar in header optional
* Allow custom color settings in the header
* Make page meta info (author, time and date info, etc) configurable separately from single post meta info
* Add Theme support for custom posts types
* Make the theme mobile-ready

If you have an idea for future development or new features, I'm open to suggestions.

If you're using the theme with your own modifications, [please use a child theme](http://codex.wordpress.org/Child_Themes) to avoid losing your customizations.

## Support
I can't guarantee a solution to every problem you may encounter, but if you contact me by any of the channels below, I'll try to help out.
I'm not affiliated with any of the previous developers. If you paid for/donated to the theme in the past and are unhappy with the way you were treated, that's on them. I'm in the same boat with you and I'm doing this on my own time, so please be nice!

Arras has a new website: http://arrastheme.net
There is no support forum yet. Please ask any questions, problems or suggestions on the appropriate post or page.

You can also open an issue on [GitHub](https://github.com/iCaspar/arras/issues), contact me by [email](mailto://caspar@iCasparWebDevelopment.com), or leave a post on the [Google Group](https://groups.google.com/forum/#!forum/arras-theme) set up by the former developers.

If you're an Arras fan and want to contribute, I welcome any help and suggestions from anyone who wants to contribute.

## Other Languages
Arras has been translated or partially translated into several languages. If you're interested in helping with translation, please drop me a line.