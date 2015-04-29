<?php
/**
 * Handles front-end styles
 *
 * @package Arras
 * @since 3.0
 */

add_action( 'wp_enqueue_scripts', 'arras_styles' );
/**
 * Enqueue styles
 */
function arras_styles() {

	$scheme = arras_get_option( 'style' );
	if ( ! isset( $scheme ) ) $scheme = 'default';

	wp_enqueue_style( 'arras-base', get_template_directory_uri() . '/css/base.css', false, '3.0', 'all' );

	if ( is_child_theme() ) {
		wp_enqueue_style( 'arras-child', get_stylesheet_uri(), array( 'arras-base' ), false, 'all' );
	}

} // end arras_styles_and_scripts()

// register_style_dir( get_template_directory() . '/css/styles/' );


$arras_layouts = array(
	'1c'	=> __('1 Column Layout (No Sidebars)', 'arras'),
	'2c-r'	=> __('2 Column Layout (Right Sidebar)', 'arras'),
	'2c-l'	=> __('2 Column Layout (Left Sidebar)', 'arras'),
	'3c-lr'	=> __('3 Column Layout (Left & Right Sidebars)', 'arras'),
	'3c-2r'	=> __('3 Column Layout (2 Right Sidebars)', 'arras'),
);

$arras_color_schemes = array(
	'Default',
	'Blue',
	'Green',
	'Orange',
	'Red',
	'Violet',
);