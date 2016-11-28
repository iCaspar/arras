<?php
/**
 * Main Theme Configuration File.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: public
 * @version: 1.0.0
 */

return [
	/***** Service Providers *****/

	'service-providers' => [

	],

	'settings' => [
		'theme-support' => [
			'title-tag'         => '',
			'post-thumbnails'   => '',
			'custom-background' => [
				'default-color' => 'f0f0f0',
			],
			'html5'             => [
				'comment-list',
				'comment-form',
				'search-form',
				'gallery',
				'caption',
				'widgets',
			],
		],

		'menus' => [
			'main' => [
				'name'            => __( 'Main Menu', 'arras' ),
				'container'       => 'nav',
				'fallback'        => 'main',
				'depth'           => 2,
				'container_class' => 'primary-nav wrap',
			],
			'top'  => [
				'name'            => __( 'Top Menu', 'arras' ),
				'container'       => 'nav',
				'fallback'        => false,
				'depth'           => 1,
				'container_class' => 'secondary-nav wrap',
			],
		],

		'sidebars' => [
			[
				'name'        => _x( 'Primary Sidebar', 'Sidebar name', 'arras' ),
				'id'          => 'primary-sidebar',
				'description' => __( 'Primary Sidebar', 'arras' ),
			],
			[
				'name'        => _x( 'Secondary Sidebar', 'Sidebar name', 'arras' ),
				'id'          => 'secondary-sidebar',
				'description' => __( 'Secondary Sidebar', 'arras' ),
			],
			[
				'name'        => _x( 'Bottom Content #1', 'Sidebar name', 'arras' ),
				'id'          => 'below-content-1',
				'description' => __( 'First area below post content', 'arras' ),
			],
			[
				'name'        => _x( 'Bottom Content #2', 'Sidebar name', 'arras' ),
				'id'          => 'below-content-2',
				'description' => __( 'Second area below post content', 'arras' ),
			],
			[
				'name'        => _x( 'Header Widgets', 'Sidebar name', 'arras' ),
				'id'          => 'header-widgets',
				'description' => __( 'A small widget area in the header. Use for small widgets', 'arras' ),
			],
		],
	],

	'option_defaults' => [
		'footer-sidebars'     => 3,
		'footer-message'      => __( 'Set your own footer message in the customizer.', 'arras' ),
		'layout'              => '2c-r',
		'display-author-page' => true,
		'post_author'         => true,
		'post_date'           => true,
		'post_cats'           => true,
		'post_tags'           => true,
		'show-post-nav'       => true,
		'single-thumbs'       => true,
		'enable-news'         => true,
	]
];