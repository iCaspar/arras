<?php
/**
 * Main Theme Configuration File.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: public
 * @version: 1.0.0
 */

return [
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
				'name'      => __( 'Main Menu', 'arras' ),
				'container' => 'nav',
				'fallback'  => 'main',
				'depth'     => 2,
				'class'     => 'primary-nav wrap',
			],
			'top'  => [
				'name'      => __( 'Top Menu', 'arras' ),
				'container' => 'nav',
				'fallback'  => false,
				'depth'     => 1,
				'class'     => 'secondary-nav wrap',
			],
		],

		'sidebars' => [
			[
				'name'        => _x( 'Primary Sidebar', 'Sidebar name', 'arras' ),
				'id'          => 'primary',
				'description' => __( 'Primary Sidebar', 'arras' ),
			],
			[
				'name'        => _x( 'Secondary Sidebar', 'Sidebar name', 'arras' ),
				'id'          => 'secondary',
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

	'options' => [
		'footer-sidebars'     => 3,
		'footer-message'      => __( 'This is a footer message.', 'arras' ),
		'layout'              => '2c-r',
		'display-author-page' => true,
		'post_author'         => true,
		'post_date'           => true,
		'post_cats'           => true,
		'post_tags'           => true,
		'show-post-nav'       => true,
	]
];