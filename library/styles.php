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
	global $arras_colors;

	// Base Stylesheet
	wp_enqueue_style( 'arras-base', get_template_directory_uri() . '/css/base.css', false, '3.0', 'all' );

	// Append color scheme (if any)
	$arras_colors->enqueue_color_scheme_css();

	if ( is_child_theme() ) {
		wp_enqueue_style( 'arras-child', get_stylesheet_uri(), array( 'arras-base' ), false, 'all' );
	}

} // end arras_styles_and_scripts()

/**
 * Returns an array of valid layouts
 *
 * Can be filtered with {@see 'arras_layouts'}.
 * @return array filtered layout options
 */
function arras_get_layouts() {
	$arras_layouts = array(
		'1c'	=> __('1 Column - No Sidebars', 'arras'),
		'2c-r'	=> __('2 Columns - Sidebar on Right', 'arras'),
		'2c-l'	=> __('2 Columns - Sidebar on Left', 'arras'),
		'3c-lr'	=> __('3 Columns - Left / Right Sidebars', 'arras'),
		'3c-2r'	=> __('3 Columns - 2 Right Sidebars', 'arras'),
	);

	return apply_filters( 'arras_layouts', $arras_layouts );
}


function arras_sanitize_layouts( $value ) {
	$layouts = arras_get_layouts();

	if ( ! array_key_exists( $value, $layouts ) ) {
		$value = '2c-r';
	}

	return $value;
}