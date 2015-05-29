<?php
/**
 * functions.php
 *
 * Arras functions and definitions.
 *
 * @author Melvin Lee (2009-2013)
 * @author Caspar Green <caspar@iCasparWebDevelopment.com>
 * @package Arras
 *
 */

/**
 * Setting a default content width is a WP theme requirement.
 * Some WordPress media and plugins may use it.
 * In a responsive context the number is a bit arbitrary; we're just
 * setting it here to be the maximum width of the main content column
 * in Arras's 2-column layouts.
 * If you need to change it, you can do so by simply defining it in the
 * functions.php of your child theme.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 647; /* maximum content width in pixels */
}

/**
 * Define theme constants
 */
define ( 'ARRAS_VERSION' , '3.0' );
define ( 'ARRAS_LIB', get_template_directory() . '/library' );

add_action( 'after_setup_theme', 'arras_i18n' );
/**
 * Make Arras Translatable
 * For how to translate Arras, see the Codex:
 * https://codex.wordpress.org/I18n_for_WordPress_Developers
 * @return null
 */
function arras_i18n() {
	load_theme_textdomain( 'arras', get_template_directory() . '/languages' );
} // end arras_i18n()

add_action( 'after_setup_theme', 'arras_theme_support' );
/**
 * Declare various theme supports for WP and plugins
 * @return null
 */
function arras_theme_support() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background', array( 'default-color' => 'f0f0f0' ) );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'widgets' ) );
} // end arras_theme_support()

add_action( 'after_setup_theme', 'arras_menus' );
/**
 * Define our theme menu locations
 * @return null
 */
function arras_menus() {
	register_nav_menus(array(
		'main-menu'	=> __('Main Menu', 'arras'),
		'top-menu'	=> __('Top Menu', 'arras')
	));
} // end arras_menus()

add_action( 'widgets_init', 'arras_add_sidebars' );
/**
 * Register widgetized areas and update sidebar with default widgets.
 * @return  null
 */
function arras_add_sidebars() {
	/* Default sidebars */
	register_sidebar( array(
		'name' => 'Primary Sidebar',
		'id'	=> 'primary',
		'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );
	register_sidebar( array(
		'name' => 'Secondary Sidebar',
		'id'	=> 'secondary',
		'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );
	register_sidebar( array(
		'name' => 'Bottom Content #1',
		'id'	=> 'below-content-1',
		'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );
	register_sidebar( array(
		'name' => 'Bottom Content #2',
		'id'	=> 'below-content-2',
		'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );
	register_sidebar( array(
		'name' => 'Header Widgets',
		'id'	=> 'header-widgets',
		'description' => 'A small widget area in the header. Use for small widgets',
		'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );

	/* Footer sidebars (Up to 4 sidebars based on user preference) */
	$footer_sidebars = arras_get_option('footer_columns');
	if ($footer_sidebars == '') $footer_sidebars = 1;

	for( $i = 1; $i < $footer_sidebars + 1; $i++ ) {
		register_sidebar( array(
			'name' => 'Footer Sidebar #' . $i,
			'id'	=> 'footer-sidebar-' . $i,
			'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer clearfix">',
			'after_widget' => '</li>',
			'before_title' => '<h5 class="widgettitle">',
			'after_title' => '</h5>'
		) );
	}
} // end arras_add_sidebars()

/* Load theme library files */
require_once ARRAS_LIB . '/actions.php';
require_once ARRAS_LIB . '/custom-header.php';
require_once ARRAS_LIB . '/customizer.php';
require_once ARRAS_LIB . '/deprecated.php';
require_once ARRAS_LIB . '/filters.php';
require_once ARRAS_LIB . '/functions.php';
require_once ARRAS_LIB . '/slideshow.php';
require_once ARRAS_LIB . '/scripts.php';
require_once ARRAS_LIB . '/styles.php';
require_once ARRAS_LIB . '/tapestries.php';
require_once ARRAS_LIB . '/template.php';
require_once ARRAS_LIB . '/thumbnails.php';
require_once ARRAS_LIB . '/update.php';
require_once ARRAS_LIB . '/widgets.php';

/* Load Admin stuff only when necessary */
if ( is_admin() ) {
	require_once ARRAS_LIB . '/admin.php';
	add_action( 'admin_menu', 'arras_addmenu' );
}


/**
 * Arras is now loaded. If you want your child theme to override
 * anything, hook your override functions to this 'after_setup_arras' hook.
 * Ex. In your child theme's functions.php:
 * 		add_action( 'after_setup_arras', 'my_overriding_function' );
 */
do_action( 'after_setup_arras' );
