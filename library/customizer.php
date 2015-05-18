<?php
/**
 * Arras Customizer Functions
 *
 * @package Arras
 * @since 3.0
 */

add_action( 'customize_register', 'arras_customizer' );
/**
 * Configures the WP Customizer for Arras
 * @param  WP_Customize_Manager $wp_customize WP Customizer object
 * @return null
 */
function arras_customizer( $wp_customize ) {
	$color_scheme = arras_get_current_color_scheme();

	// Add color scheme setting and control.
	$wp_customize->add_setting(
		'color_scheme',
		array(
			'default'			=> 'default',
			'sanitize_callback' => 'arras_sanitize_color_scheme',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => __( 'Base Color Scheme', 'arras' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => arras_get_color_scheme_choices(),
		'priority' => 1,
	) );

	// Add custom header color (this is the background color for the entire header area)
	$wp_customize->add_setting(
		'header_background_color',
		array(
			'default'			=> $color_scheme[0],
			'sanitize_callback'	=> 'sanitize_hex_color',
	) );

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_background_color',
			array(
				'label'		=> __( 'Header Background Color', 'arras' ),
				'section'	=> 'colors',
				'settings'	=> 'header_background_color',
				'priority'	=> 3,
			)
		)
	);

	// Add Logo Uploader
	$wp_customize->get_section( 'header_image' )->title = __( 'Header Image and Logo', 'arras' );
	$wp_customize->add_setting(
		'arras-options[site_logo]',
		array(
			'default'			=> esc_url( get_option( 'arras-options[site_logo]' ) ),
			'type'				=> 'option',
			'sanitize_callback'	=> 'esc_url_raw',
	) );
	$wp_customize->add_control(
		new WP_Customize_Upload_Control(
			$wp_customize,
			'site_logo',
			array(
				'label'		=> __( 'Site Logo', 'arras' ),
				'section'	=> 'header_image',
				'settings'	=> 'arras-options[site_logo]',
				'priority'	=> 1,
			)
		)
	);

	// Add Layout Section
	$wp_customize->add_section( 'layout',
	array(
		'title'		=> 'Layout',
		'priority'	=> 100,
	) );

	// Add Layout Settings
	$wp_customize->add_setting(
		'arras-options[layout]',
		array(
			'default'			=> '2c-r',
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_layouts',
	) );
	$wp_customize->add_control( 'layout', array(
		'label'		=> __( 'Sidebar Arrangement', 'arras' ),
		'section'	=> 'layout',
		'settings'	=> 'arras-options[layout]',
		'type'		=> 'select',
		'choices'	=> arras_get_layouts(),
		'priority'	=> 1,
	) );

	// Add Default Tapestry
	$wp_customize->add_setting(
		'arras-options[default_tapestry]',
		array(
			'default'			=> 'quick',
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_tapestries',
	) );
	$wp_customize->add_control( 'default-tapestry', array(
		'label'		=> __( 'Default Tapestry', 'arras' ),
		'section'	=> 'layout',
		'settings'	=> 'arras-options[default_tapestry]',
		'type'		=> 'select',
		'choices'	=> arras_get_tapestry_choices(),
		'priority'	=> 2,
	) );

	// Add Auto Thumbnail Option
	$wp_customize->add_setting(
		'arras-options[auto_thumbs]',
		array(
			'default'			=> true,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
	) );
	$wp_customize->add_control( 'auto-thumbs', array(
		'label'		=> __( 'Auto-Thumbnail', 'arras' ),
		'description'	=> __( 'Automatically retrieve the first attached image from the post as featured image when no image is specified.', 'arras' ),
		'section'	=> 'layout',
		'settings'	=> 'arras-options[auto_thumbs]',
		'type'		=> 'checkbox',
		'priority'	=> 3,
	) );
} // end arras_customizer()

/**
 * Makes sure a boolian input resolves to true or false
 * @param  mixed $value raw input
 * @return boolian        0 or 1
 */
function arras_sanitize_boolian( $value ) {
	$value = ( $value ) ? true : false;
	return $value;
}
