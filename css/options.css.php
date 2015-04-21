<?php
/**
 * This file is loaded via AJAX to generates css "on the fly" based on
 * conditions and options at runtime. It is called from arras_options_css()
 * and is hooked into wp_enqueue_scripts with our other styles via
 * arras_enqueue_styles_and_scripts().
 */

/* Since this file is loaded via AJAX, we have to send a header first. */
header( 'Content-type: text/css' );

/* From here we can access any WP or theme functions to generate the css. */

arras_constrain_footer_sidebars();