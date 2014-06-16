# Arras WordPress Theme

## Overview
Arras is a sophisticated, yet simple and clean WordPress theme for magazine/news blogs with the following features:

* Homepage comes with a featured slideshow and 3 featured post areas with 4 different customizable layouts.
* Comes with one-, two- and three-column layouts and 7 different alternate styles.
* WordPress 3.9-ready with two menu locations, custom post types and custom taxonomies support.
* Child theme ready with numerous action and filter hooks available for use.

## History
Arras was originally released as a Premium WordPress theme.
In 2009 it was released as a public project on GitHub by Lead Developer, Melvin Lee (@zyml).

Lee's team worked on the project from 2009 - 2012, and started a second project, AR2, that was released as Arras 2.0 in 2012.
The last commit was May 21, 2013, but a new version was never released.

As of May 1, 2014 the theme's website, http://www.arrastheme.com, announced that the developers were discontinuing the project, and releasing it to any interested parties for further development under the *GNU General Public License v2*. Inquiries were referred to a Google groups page (https://groups.google.com/forum/#!forum/arras-theme) for assistance, and to the project on Github.

## Resumed Development at iCaspar Web Development
**iCaspar Web Development is undertaking this project as an open source project without any warrantee that development will continue, or that the results will be fit for use by anyone for any purpose. iCaspar Web Development is not affiliated with, nor do I have contact with, any previous developers of the Arras theme, nor have I received any payment or benefits from the former developers, other than the GNU licensed code itself.**

## Version 1.6 RC1
Version 1.6 brings Arras up-to-date with WordPress 3.9.1

### Bug Fixes:
* Fix Legacy style: Submenu not covering items on wrapped menu leaving double image.
* Fix missing argument in function call to current_user_can() in library/filters.php
* Fix non-variable call by reference in comments.php
* Fix Older/Newer Entries link layout on Search Results
* Fix Default style: Text not visible on menu levels greater than 2
* Fix Top Menu div appears with empty content

### WordPress Compliance Fixes:
* Use wp_title() in head - Rewrite arras_document_title() and use add_filter to include
* Rewrite arras_body_class() and include via add_filter('body_class')
* Fix inappropriate use of TEMPLATEPATH constant
* Fix inappropriate use of hard-coded links
* Load all stylesheets via enqueue_styles() instead of using @import

### New Features, Updates and Changes
* Change Doctype to html (HTML5) and Implement HTML5 tags - header, nav, footer
* Deprecate arras_document_description()
* Update jQuery cycle to cycle2 (v2.1.5)
* Combine all Arras Options onto a single Arras Options Page in the Appearance Menu
* Add support for Native WordPress Appearance > Header options
* Replace Search Bar in Header with fully functional Widget Area

## Support
If you're using the theme with your own modifications, [please use a child theme](http://codex.wordpress.org/Child_Themes) to avoid losing your customizations.

I can't guarantee a solution to every problem you may encounter, but if you contact me by any of the channels below, I'll try to help out.
I'm not affiliated with any of the previous developers. If you paid for/donated to the theme in the past and are unhappy with the way you were treated, that's on them. I'm in the same boat with you and I'm doing this on my own time, so please be nice!

Arras has a new website: http://arrastheme.net
There is no support forum yet. Please ask any questions, problems or suggestions on the appropriate post or page.

You can also open an issue on [GitHub](https://github.com/iCaspar/arras/issues), contact me by [email](mailto://caspar@iCasparWebDevelopment.com), or leave a post on the [Google Group](https://groups.google.com/forum/#!forum/arras-theme) set up by the former developers.

If you're an Arras fan and want to contribute, I welcome any help and suggestions from anyone who wants to contribute.

## Other Languages
Arras has been translated or partially translated into several languages. If you're interested in helping with translation, please drop me a line.