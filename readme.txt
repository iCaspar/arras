# Arras

## Overview

Arras is a sophisticated, yet simple and clean WordPress theme for magazine/news blogs with the following features:

* Homepage comes with a slideshow and 3 featured post areas and 4 different customizable layouts.
* Comes with one-, two- and three-column layouts and 7 different alternate styles.
* WordPress 4.2-ready with two menu locations, custom post types and custom taxonomies support.
* Child theme ready with numerous action and filter hooks available for use.

## Version 3. (Alpha-01)

Version 3 brings Arras up-to-date with WordPress 4.2 and adds a responsive framework. Arras 3 *requires WordPress 4.1 or higher*.

Because of the major changes in this version, it is not backwards compatibile with version Arras version 1.x.

### Change Log (Arras 1.6.2 -- Arras 3.0 Alpha-01)

***This version is for testing only. Do not install on production websites!***

* Implement WP title-tag support, remove arras_title()
* Remove arras_setup() and relocate various sub-functions:
	* Theme support declarations into new arras_theme_support()
	* Move menu functions into new arras_menu()
	* Move wp_head() actions to new arras_scripts() and arras_styles()
	* Fix incorrect sidebar registration loading sidebars without an id
* Fix deprecated use of caller_get_posts() in sidebar.php
* Remove user.css
* Remove yarpp template
* Remove pagetpl-redirect template
* Rename pagetpl-single.php to no-sidebar-page.php
* Rename pagetpl-archive.php to archive-page.php
* Remove superfish.js menu, implement CSS3-driven menu
* Remove smoothness.js from admin
* Remove tabbed sidebar widget
* Remove tag cloud widget
* Add skip-links and styles for Accessibility
* Add Mobile Friendly capacity:
	* Add Responsive Grid CSS
	* Update all templates for use with Responsive Grid
	* Update tapestry functions for use with Responsive Grid
	* Update homepage slideshow for Responsive Grid
	* Add mobile swipe gestures on slideshow
	* Restructure thumbnail (featured image) support to use native WP sizes plus wide-screen size and small-square size
	* Add mobile main nav CSS for small screens ( < 768px wide )
	* Update dynamic footer widget sizing functions
* Update Options Page Tabs:
	* Refactor for Responsive layout changes
	* Remove "Thumbnails" Tab, move "Auto Thumbs" option to "Layout" Tab.
	* Move Layout selection from "Design" to "Layout" Tab
	* Update Header Background Color option to use WP colorpicker
	* Fix backgrounds not appearing on multi-select dropdowns
* Update arras_styles() to load child theme stylesheet automatically
* Merge default.css into base.css and lint:
	* Remove duplicate style definitions (still in progress)
	* Remove px-based font-sizes, implemente rem-based sizes
	* Remove all instances of !important
* Update Theme Tags

**NOTE:**

* The design tab on the options page still allows you to choose from the various color schemes, but the CSS for implementing those color schemes has not yet been adapted for the new responsive grid, so in Alpha-01 you can select an alternate style, but the selection will be ignored.
* The use of custom thumbnail sizing for various theme locations in a responsive grid system is of no use. Everything resizes dynamically. Setting of custom thumbnail sizes has been discontinued in favor of using the native WP thumbnail sizes, plus a small-square thumbnail, and a wide-screen thumbnail size that sets the thumnail ratio for the slideshow and node tapestry to a 16:9 ratio (the same ratio your wide-screen TV uses).
* The Secondary Sidebar Widget area will appear only on 3-column layouts. Neither sidebar will appear on single-column layouts. Below-content widget areas appear only on the home page.
*

### Roadmap (Will change as work progresses)

**Alpha-02**

* Complete removal of duplicate styles from base.css
* Refactor color scheme CSS and re-enable use of color-scheme selection
* Triage reported bugs from Alpha-01

**Alpha-03**

* Refactor options to use WordPress.org array via settings API
* Review and refactor options security and validation
* Triage reported bugs from Alpha-02

**Alpha-04**

* Move options from Theme Options page to Customizer
* Triage reported bugs from all Alphas

**Beta-01**

* Second security review
* Implement bug fixes from Alphas
* Implement "easy" suggested features from Alphas

**Beta-02**

* Third security review
* Implement all bug fixes from Beta-01
* Punt remaining suggested features to 3.1

**Beta-03 (if necessary)**

* Final bug fixes before release

**3.0**

### Support

If you're using the theme with your own modifications, [please use a child theme](http://codex.wordpress.org/Child_Themes) to avoid losing your customizations in future releases.

Arras Version 3 has a support forum at http://forum.arrastheme.net. You can also open an issue on [GitHub](https://github.com/iCaspar/arras/issues).

If you're an Arras fan and want to contribute, I welcome any help and suggestions from anyone who wants to contribute.

## Other Languages

Arras 3 is translation ready.

## History

Arras was originally released as a Premium WordPress theme.
In 2009 it was released as a public project on GitHub by Lead Developer, Melvin Lee (@zyml).

Lee's team worked on the project from 2009 - 2012, and started a second project, AR2, that was released as Arras 2.0 in 2012.
The last commit was May 21, 2013, but a new version was never released.

As of May 1, 2014 the theme's website, http://www.arrastheme.com, announced that the developers were discontinuing the project, and releasing it to any interested parties for further development under the *GNU General Public License v2*. Inquiries were referred to a Google groups page (https://groups.google.com/forum/#!forum/arras-theme) for assistance, and to the project on Github.

## Resumed Development at iCaspar Web Development

**iCaspar Web Development is undertaking this project as an open source project without any warrantee that development will continue, or that the results will be fit for use by anyone for any purpose. iCaspar Web Development is not affiliated with, nor do I have contact with, any previous developers of the Arras theme, nor have I received any payment or benefits from the former developers, other than the GNU licensed code itself.**

