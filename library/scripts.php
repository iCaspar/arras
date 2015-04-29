<?php
/**
 * Handlers of front-end scripts
 *
 * @package Arras
 * @since 3.0
 */

add_action( 'wp_enqueue_scripts', 'arras_scripts' );
/**
 * Enqueue scripts
 */
function arras_scripts() {
	global $paged;

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
}