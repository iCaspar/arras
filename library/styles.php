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
	// Base Stylesheet
	wp_enqueue_style( 'arras-base', get_template_directory_uri() . '/css/base.css', false, '3.0', 'all' );

	// Append color scheme (if any)
	arras_color_scheme_css();

	if ( is_child_theme() ) {
		wp_enqueue_style( 'arras-child', get_stylesheet_uri(), array( 'arras-base' ), false, 'all' );
	}
} // end arras_styles_and_scripts()


/**
 * Returns the current color scheme colors array, or default color array
 * @return array color scheme array of colors
 */
function arras_get_current_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	$available_color_schemes = arras_color_schemes();

	if ( array_key_exists( $color_scheme_option, $available_color_schemes ) ) {
		return $available_color_schemes[ $color_scheme_option ]['colors'];
	}

	return $available_color_schemes['default']['colors'];
}

/**
 * Validates color scheme selection from Customizer
 * @param  string $value user-entered color scheme name
 * @return string        validated color scheme name
 */
function arras_sanitize_color_scheme( $value ) {
	$color_schemes = arras_color_schemes();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		$value = 'default';
	}

	return $value;
}

/**
 * Generates an array for Customizer Color Scheme Control Drop-down list
 * @return array color scheme choices for selection in select control
 */
function arras_get_color_scheme_choices() {
	$color_schemes                = arras_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return $color_scheme_control_options;
}

/**
 * Register Arras built-in color schemes
 *
 * Can be filtered with {@see 'arras_color_schemes'}.
 *
 * The order of colors in array:
 * 1. Header Backgrounds and Heading Text Color
 * 2. Main Navigation Background and Link Color
 * 3. Main Naveigation and Link/Button Hover Color
 * 4. Supplemental Navigation Background
 *
 * @since 3.0
 *
 * @return array An associative array of color scheme options.
 */
function arras_color_schemes() {
	return apply_filters( 'arras_color_schemes', array(
		'default' => array(
			'label'  => __( 'Default', 'arras' ),
			'colors' => array(
				'#1e1b1a',
				'#322c2c',
				'#383332',
				'#111111',
			),
		),
		'blue'    => array(
			'label'  => __( 'Blue', 'arras' ),
			'colors' => array(
				'#091e36',
				'#003773',
				'#0f3158',
				'#061424',
			),
		),
		'green'  => array(
			'label'  => __( 'Green', 'arras' ),
			'colors' => array(
				'#204000',
				'#336500',
				'#407e19',
				'#0d1900',
			),
		),
		'rust'    => array(
			'label'  => __( 'Rust', 'arras' ),
			'colors' => array(
				'#5c2203',
				'#87340e',
				'#632a0b',
				'#2e1101',
			),
		),
		'wine'  => array(
			'label'  => __( 'Wine', 'arras' ),
			'colors' => array(
				'#3d0a00',
				'#7e1e14',
				'#721b12',
				'#330800',
			),
		),
		'violet'   => array(
			'label'  => __( 'Violet', 'arras' ),
			'colors' => array(
				'#320a33',
				'#581259',
				'#4b0f4c',
				'#390b3b',
			),
		),
	) );
}

/**
 * Enqueues front-end CSS for color scheme.
 * @since 3.0
 */
function arras_color_scheme_css() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );

	// Don't do anything if the default color scheme is selected.
	if ( 'default' === $color_scheme_option ) {
		return;
	}

	$color_scheme = arras_get_current_color_scheme();

	$colors = array(
		'header_background_color'     => $color_scheme[0],
		'main_nav_link_color'         => $color_scheme[1],
		'hover_color'                 => $color_scheme[2],
		'supplemental_color'          => $color_scheme[3],
	);

	$color_scheme_css = <<<CSS
	/* Color Scheme */

	/* Header */
	.page-header {
		background: {$colors['header_background_color']};
		border-bottom-color: {$colors['hover_color']};
	}
	.primary-utility,
	.top-menu ul ul {
		background: {$colors['supplemental_color']};
	}
	.nav,
	.main-menu ul ul,
	.main-menu ul ul ul {
		background: {$colors['main_nav_link_color']};
	}
	.main-menu li:hover,
	.main-menu li li:hover {
		background-color: {$colors['hover_color']};
	}

	/* Headings */
	.home-title,
	.author-title,
	.archive-title {
		color: {$colors['header_background_color']};
	}

	/* Links and Buttons */
	a:link,
	a:visited {
		color: {$colors['main_nav_link_color']};
	}
	.a:hover {
		color: {$colors['hover_color']};
	}
	.posts-quick .quick-read-more a:hover,
	.comment-list .reply a:hover,
	.comments-navigation a:hover,
	.navigation a:hover,
	.read-more:hover {
		background: {$colors['hover_color']};
	}

	/* Widgets */
	.widgettitle {
		background: {$colors['main_nav_link_color']}
	}
CSS;

	wp_add_inline_style( 'arras-base', $color_scheme_css );
}


$arras_layouts = array(
	'1c'	=> __('1 Column Layout (No Sidebars)', 'arras'),
	'2c-r'	=> __('2 Column Layout (Right Sidebar)', 'arras'),
	'2c-l'	=> __('2 Column Layout (Left Sidebar)', 'arras'),
	'3c-lr'	=> __('3 Column Layout (Left & Right Sidebars)', 'arras'),
	'3c-2r'	=> __('3 Column Layout (2 Right Sidebars)', 'arras'),
);