<?php

namespace Arras;

use Arras\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Oops! Something went wrong.' );
}

require_once 'vendor/autoload.php';

initConstants();

require_once ARRAS_LIB . '/admin/options.php';
require_once ARRAS_LIB . '/admin/templates/functions.php';
require_once ARRAS_LIB . '/admin/update.php';
arras_flush_options();

require_once ARRAS_LIB . '/actions.php';
require_once ARRAS_LIB . '/deprecated.php';
require_once ARRAS_LIB . '/filters.php';
require_once ARRAS_LIB . '/tapestries.php';
require_once ARRAS_LIB . '/template.php';
require_once ARRAS_LIB . '/thumbnails.php';
require_once ARRAS_LIB . '/slideshow.php';
require_once ARRAS_LIB . '/widgets.php';

if ( is_admin() ) {
	require_once ARRAS_LIB . '/admin/admin.php';
}

initArras();

function initConstants() {
	$theme = wp_get_theme();

	define( 'ARRAS_VERSION', $theme->get( 'Version' ) );
	define( 'ARRAS_URL', $theme->get( 'ThemeURI' ) );
	define( 'ARRAS_CONFIG_DIR', get_template_directory() . '/config' );
	define( 'ARRAS_LIB', get_template_directory() . '/library' );
	define( 'ARRAS_ASSET_URL', get_template_directory_uri() . '/assets' );
	define( 'ARRAS_REVIEW_SCORE', 'score' );
	define( 'ARRAS_REVIEW_PROS', 'pros' );
	define( 'ARRAS_REVIEW_CONS', 'cons' );
	define( 'ARRAS_CHILD', is_child_theme() );
}

function initArras() {
	$theme = new Theme( include ARRAS_CONFIG_DIR . '/config.php' );
	do_action( 'arras_init', $theme );
	$theme->init();
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\arras_setup' );
function arras_setup() {
	load_theme_textdomain( 'arras', get_template_directory() . '/language' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'custom-logo', [
		'height'      => 125,
		'width'       => 400,
		'flex-width'  => true,
		'header-text' => [ 'site-name', 'site-description' ],
	] );

	register_nav_menus( array(
		'main-menu' => __( 'Main Menu', 'arras' ),
		'top-menu'  => __( 'Top Menu', 'arras' )
	) );

	arras_add_default_thumbnails();

	arras_add_sidebars();

	remove_action( 'wp_head', 'pagenavi_css' );
	add_action( 'arras_beside_nav', 'arras_social_nav' );
	add_action( 'wp_head', 'arras_head' );

	add_filter( 'arras_postheader', 'arras_post_taxonomies' );
	add_filter( 'use_default_gallery_style', '__return_false' );

	if ( defined( 'ARRAS_CUSTOM_FIELDS' ) && ARRAS_CUSTOM_FIELDS == true ) {
		add_filter( 'arras_postheader', 'arras_postmeta' );
	}

	if ( is_admin() ) {
		add_action( 'admin_menu', 'arras_addmenu' );
	}

	do_action( 'arras_setup' );
}