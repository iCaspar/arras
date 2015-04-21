<?php
/**
 * All style- and script-loading functionality.
 */
global $arras_layouts, $arras_registered_style_dirs;

add_action( 'wp_enqueue_scripts', 'arras_styles_and_scripts' );
/**
 * Enqueue scripts and styles.
 */
function arras_styles_and_scripts() {
	global $paged, $arras_registered_alt_styles;

	// Slideshow scripts - only on first page of homepage and only if slideshow is enabled
	if ( is_home() && ! $paged && arras_get_option( 'enable_slideshow' ) == true ) {
		wp_enqueue_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle2-min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'slideshow-settings', get_template_directory_uri() . '/js/slideshowsettings.js', array( 'jquery-cycle' ), null, true );
		wp_enqueue_script( 'jquery-cycle-caption', get_template_directory_uri() . '/js/jquery.cycle2.caption2.min.js', array( 'slideshow-settings' ), null, true );
		wp_enqueue_script( 'jquery-cycle-swipe', get_template_directory_uri() . '/js/jquery.cycle2.swipe.min.js', array( 'slideshow-settings' ), null, true );
	}

	// Comment reply scripts - only on single pages
	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( ! defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
		$scheme = arras_get_option( 'style' );
		$css_base_path = '/css/';
		if ( ! isset( $scheme ) ) $scheme = 'default';

		$css_path = $css_base_path . 'styles/' . $scheme;

		if ( $scheme != 'legacy' ) {
			if ( ! is_rtl() ) {
				wp_enqueue_style( 'arras-base', get_template_directory_uri() . $css_base_path . 'base.css', false, '3.0', 'all' );
				wp_enqueue_style( 'arras-default', get_template_directory_uri() . $css_base_path . 'styles/default.css', array( 'arras-base' ), '1.6', 'all' );
			} else {
				wp_enqueue_style( 'arras-base-rtl', get_template_directory_uri() . $css_base_path . 'base-rtl.css', false, '1.6', 'all' );
				wp_enqueue_style( 'arras-default-rtl', get_template_directory_uri() . $css_base_path . 'styles/default-rtl.css', array( 'arras-base-rtl' ), '1.6', 'all' );
			}
		}
		if ( is_rtl() ) $css_path .= '-rtl';
		if ( $scheme != 'default' ) {
			wp_enqueue_style( 'arras-schema', get_template_directory_uri() . $css_path . '.css', false, '1.6', 'all' );
		}
	}
	// load other custom styles
	do_action( 'arras_load_styles' );


	// Load dynamically generated css
	// wp_enqueue_style( 'arras-options-generated', admin_url( 'admin-ajax.php' ) . '?action=arras_options_css', 'arras-base', null, 'screen' );

} // end arras_styles_and_scripts()



//add_action( 'wp_ajax_arras_options_css', 'arras_options_css' );
//add_action( 'wp_ajax_nopriv_arras_options_css', 'arras_options_css' );

function arras_options_css() {
	require get_template_directory() . '/css/options.css.php';
	exit; // Must explicitly exit or we get an extra "0" returned into the end of our css
}

register_style_dir( get_template_directory() . '/css/styles/' );


$arras_layouts = array(
	'1c'	=> __('1 Column Layout (No Sidebars)', 'arras'),
	'2c-r'	=> __('2 Column Layout (Right Sidebar)', 'arras'),
	'2c-l'	=> __('2 Column Layout (Left Sidebar)', 'arras'),
	'3c-lr'	=> __('3 Column Layout (Left & Right Sidebars)', 'arras'),
	'3c-2r'	=> __('3 Column Layout (2 Right Sidebars)', 'arras'),
);


function register_style_dir($dir) {
	global $arras_registered_style_dirs;
	$arras_registered_style_dirs[] = $dir;
}

function is_valid_arras_style($file) {
	return (bool)( !preg_match('/^\.+$/', $file) && preg_match('/^[A-Za-z][A-Za-z0-9\-]*.css$/', $file) );
}
