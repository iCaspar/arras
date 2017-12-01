<?php
/*
 * Template Name: Redirect Page
 */

if ( have_posts() ) {
	the_post();

	$URL = get_the_excerpt();

	if ( preg_match( '/(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?/', $URL ) ) {
		$URL = esc_url( $URL );
		if ( wp_redirect( $URL ) ) {
			exit();
		}
	} else {
		wp_reset_postdata();
		include 'page.php';
	}
}