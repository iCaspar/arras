<?php

arras_init_constants();

function arras_init_constants() {
	$theme = wp_get_theme();

	define( 'ARRAS_VERSION', $theme->get( 'Version' ) );
	define( 'ARRAS_URL', $theme->get( 'ThemeURI' ) );
	define( 'ARRAS_LIB', get_template_directory() . '/library' );
	define( 'ARRAS_REVIEW_SCORE', 'score' );
	define( 'ARRAS_REVIEW_PROS', 'pros' );
	define( 'ARRAS_REVIEW_CONS', 'cons' );
	define( 'ARRAS_CHILD', is_child_theme() );
}

do_action( 'arras_init' );

add_action( 'after_setup_theme', 'arras_setup' );

function arras_setup() {
	require_once ARRAS_LIB . '/admin/options.php';
	require_once ARRAS_LIB . '/admin/templates/functions.php';
	arras_flush_options();

	require_once ARRAS_LIB . '/actions.php';
	require_once ARRAS_LIB . '/deprecated.php';
	require_once ARRAS_LIB . '/filters.php';
	require_once ARRAS_LIB . '/tapestries.php';
	require_once ARRAS_LIB . '/template.php';
	require_once ARRAS_LIB . '/thumbnails.php';
	require_once ARRAS_LIB . '/styles.php';
	require_once ARRAS_LIB . '/slideshow.php';
	require_once ARRAS_LIB . '/widgets.php';

	if ( is_admin() ) {
		require_once ARRAS_LIB . '/admin/admin.php';
	}

	load_theme_textdomain( 'arras', get_template_directory() . '/language' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'nav-menus' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'custom-logo', [
		'height'      => 125,
		'width'       => 400,
		'flex-width'  => true,
		'header-text' => [ 'blog-name' ],
	] );

	register_nav_menus( array(
		'main-menu' => __( 'Main Menu', 'arras' ),
		'top-menu'  => __( 'Top Menu', 'arras' )
	) );

	arras_add_default_thumbnails();

	arras_add_sidebars();

	register_alternate_layout( '1c-fixed', __( '1 Column Layout (No Sidebars)', 'arras' ) );
	register_alternate_layout( '2c-r-fixed', __( '2 Column Layout (Right Sidebar)', 'arras' ) );
	register_alternate_layout( '2c-l-fixed', __( '2 Column Layout (Left Sidebar)', 'arras' ) );
	register_alternate_layout( '3c-fixed', __( '3 Column Layout (Left & Right Sidebars)', 'arras' ) );
	register_alternate_layout( '3c-r-fixed', __( '3 Column Layout (Right Sidebars)', 'arras' ) );

	register_style_dir( get_template_directory() . '/css/styles/' );

	remove_action( 'wp_head', 'pagenavi_css' );
	add_action( 'arras_head', 'arras_override_styles' );
	add_action( 'arras_custom_styles', 'arras_constrain_footer_sidebars' );
	add_action( 'arras_beside_nav', 'arras_social_nav' );
	add_action( 'wp_head', 'arras_load_styles', 1 );
	add_action( 'wp_head', 'arras_head' );
	add_action( 'wp_head', 'arras_add_facebook_share_meta' );
	add_action( 'wp_head', 'arras_add_header_js' );
	add_action( 'wp_footer', 'arras_add_footer_js' );

	add_filter( 'arras_postheader', 'arras_post_taxonomies' );
	add_filter( 'gallery_style', 'remove_gallery_css' );

	if ( defined( 'ARRAS_CUSTOM_FIELDS' ) && ARRAS_CUSTOM_FIELDS == true ) {
		add_filter( 'arras_postheader', 'arras_postmeta' );
	}

	if ( is_admin() ) {
		add_action( 'admin_menu', 'arras_addmenu' );
	}

	do_action( 'arras_setup' );
}