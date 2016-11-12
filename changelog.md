### 4.0.0-alpha1

* Implement Object Oriented structure with PSR-4 autoloading via Composer
* Refactor base template files for use with Arras/TemplateEngine class
* Refactor styles for new templates
* Add FontAwesome
* Implement SASS with IT-SASS structure
* Implement CSS, JS and image minimization
* Implement postMessage transport in WP Customizer
* Remove legacy code and images from distribution files

----------

### Arras 3.0.3

* Fix default tapestry no registering on author pages
* Fix entry comment css for traditional tapestry
* Add Italian translation HT: Alex Tudisco

### Arras 3.0.2

* Restore white background to traditional tapestry

### Arras 3.0.1

* Remove old language files
* Fix css border errors

### Arras  3.0

* Various Customizer fixes
* Remove deprecated functions

### Change Log - Arras 3.0-beta1

* Move all settings and options to customizer
* Discontinue Arras Options admin page with Arras Info page
* Add default background color
* Add spacing between lines of nodes in node-based display mode
* Add custom customizer styles
* Fix site logo area collapse when neither header text nor logo image is displayed
* Fix home page sections not rendering when setting is left blank
* Add settings importer to regenerate Arras 1.x options on first activation

### Change Log - Arras 3.0 Alpha-02

* Complete removal of duplicate styles from base.css
* Refactor color schemes
* Add Base Color Schemes to Customizer
* Remove Color Scheme option from Arras Options page Design Tab
* Add new color scheme functions to style.php
* Remove css/styles/$color.css files
* Remove minimum logo height

### Change Log (Arras 1.6.2 -- Arras 3.0 Alpha-01)

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