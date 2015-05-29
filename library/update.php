<?php

// First, we need a stripped-down version of the old ArrasOptions class in order to access the old options object
class ArrasOptions {
	var $defaults;
	var $version, $donate, $feed_url, $comments_feed_url, $twitter_username, $facebook_profile, $footer_title, $footer_message;
	var $topnav_home, $topnav_display, $topnav_linkcat;
	var $hide_duplicates;
	var $enable_slideshow, $slideshow_cat, $slideshow_count;
	var $enable_featured1, $featured1_title, $featured1_cat, $featured1_display, $featured1_count;
	var $enable_featured2, $featured2_title, $featured2_cat, $featured2_display, $featured2_count;
	var $enable_news, $news_title, $news_cat, $news_display, $index_count;
	var $archive_display;
	var $display_author, $single_custom_fields, $single_custom_taxonomies;
	var $excerpt_limit;
	var $post_author, $post_date, $post_cats, $post_tags, $postbar_footer, $single_thumbs;
	var $auto_thumbs, $custom_thumbs;
	var $layout, $style, $logo, $footer_sidebars, $header_color;
	var $slideshow_posttype, $featured1_posttype, $featured2_posttype, $news_posttype;
	var $slideshow_tax, $featured1_tax, $featured2_tax, $news_tax;

	function __construct() { $this->default_options(); }

	function ArrasOptions() { return $this->__construct(); }
} // end class ArrasOptions

add_action( 'after_switch_theme', 'arras_options_upgrade' );

function arras_options_upgrade() {
	// If we've already done this, bail
	if ( arras_get_option( 'updated' ) ) return;
	$new_options = array();
	$settings = arras_get_settings_data();
	// Load our Arras 3 default settings
	foreach ( $settings as $key => $value ) {
		$new_options[$key] = $value[0];
	}

	// See if we have any old options,
	$old_options = maybe_unserialize( get_option( 'arras_options' ) );
	if ( 'object' == gettype( $old_options ) ) {
		// Arras 1.x stored tapestry info in a second place in the options table
		$old_tapestry_default = maybe_unserialize( get_option( 'arras_tapestry_default' ) );

		// Retrieve the old defaults into an array
		foreach ( $old_options->defaults as $key => $value ) {
			$new_options[$key] = $value;
		}

		// Now get the non-default settings (and overwrite the defaults for those that have been set)
		unset( $old_options->defaults ); // we're done with those
		foreach ( $old_options as $key => $value ) {
			$new_options[$key] = $value;
		}
		// Add the loose settings, too!
		if ( is_array( $old_tapestry_default ) ) {
			$new_options['nodes_per_row'] = $old_tapestry_default['nodes'];
			$new_options['nodes_excerpt'] = $old_tapestry_default['excerpt'];
		}

		// Check for renamed settings
		$new_names = array(
			'logo' => 'site_logo',
			'header_color' => 'header_background_color',
			'facebook_profile' => 'facebook',
			'twitter_username' => 'twitter',
			'gplus_profile' => 'google',
			'flickr_profile' => 'flickr',
			'youtube_profile' => 'youtube' );
		foreach ( $new_names as $old_name => $new_name ) {
			if ( array_key_exists( $old_name, $new_options ) && ! empty( $new_options[$old_name] ) )
				$new_options[$new_name] = $new_options[$old_name];
		}
	}

	// One last pass to clean things up
	foreach ( $new_options as $key => $value ) {
		if ( ! array_key_exists( $key, $settings ) ) unset( $new_options[$key] );
	}

	// Write the translated options back to the database as Arras 3 options
	$new_options[ 'updated' ] = true;
	update_option( 'arras-options', $new_options );
}