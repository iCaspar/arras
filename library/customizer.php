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
			'default'           => 'default',
			'sanitize_callback' => 'arras_sanitize_color_scheme',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => __( 'Base Color Scheme', 'arras' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => arras_get_color_scheme_choices(),
		'priority' => 1,
	) );
} // end arras_customizer()
