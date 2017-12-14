<?php
/**
 * functions.php
 */

/**
 * You can access and use anything in Arras's theme object by calling
 * $arras = \Arras\Theme::getArras();
 *
 * The sample functions below, adding child stylesheet overrides, demonstrate how this works.
 */


// Un-comment the next line to use the arras_add_child_styles() function.
//add_action( 'wp_enqueue_scripts', 'arras_child_styles' );
/**
 * Add the child theme's style.css.
 *
 * The following will cause the child theme's styles to be loaded after the main Arras theme styles.
 */
function arras_add_child_styles() {
	$arras                  = \Arras\Theme::getArras();                 // pull in the Arras Theme
	$currentArrasStylesheet = $arras->assets->getCurrentStyleHandle();  // get the current main theme stylesheet

	wp_enqueue_style(                                                   // enqueue the child theme's style.css file
		'arras-child',
		get_stylesheet_uri(),
		[ $currentArrasStylesheet ],
		'1.0.0',
		'all'
	);
}

// Un-comment the next line to use the arras_child_replace_styles function
//add_action( 'wp_enqueue_scripts', 'arras_child_replace_styles' );
function arras_child_replace_styles() {
	$arras = \Arras\Theme::getArras();                                  // pull in the Arras Theme
	remove_action( 'wp_enqueue_scripts',                                // remove the Arras Theme styles
		[ $arras->assets, 'enqueueStyles' ], 15 );

	wp_enqueue_style(                                                   // enqueue the child theme's style.css file
		'arras-child',
		get_stylesheet_uri(),
		[],
		'1.0.0',
		'all'
	);
}