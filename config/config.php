<?php
/**
 * Configuration file for Arras.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

return [
	/**
	 * Default option selections.
	 */
	'defaults'          => [
		'footer-sidebars'     => 3,
		'footer-message'      => __( 'Set your own footer message in the customizer.', 'arras' ),
		'layout'              => 'SingleRightSidebar',
		'display-author-page' => false,
		'display-author-post' => true,
		'post_author'         => true,
		'post_date'           => true,
		'post_cats'           => true,
		'post_tags'           => true,
		'show-post-nav'       => true,
		'single-thumbs'       => true,
		'enable-news'         => true,
	],

	/**
	 * Service Providers
	 */
	'service-providers' => [
		'layout'  => [
			'class'     => 'ICaspar\Arras\Theme\Layouts\LayoutFactory',
			'source'    => 'option',
			'parameter' => 'layout',
		],
		'menus'          => [
			'class'     => 'ICaspar\Arras\Theme\Menus\MenuController',
			'source'    => 'config',
			'parameter' => 'menus',
		],
		'templateLoader' => 'ICaspar\Arras\Theme\Templates\TemplateLoader',
		'comments'       => 'ICaspar\Arras\Theme\Comments\ArrasComments',
	],

	/**
	 * Menu Definitions
	 */
	'menus'             => [
		'main' => [
			'name'      => __( 'Main Menu', 'arras' ),
			'container' => 'nav',
			/*'fallback'  => 'main',*/
			'depth'     => 2,
			'class'     => 'primary-nav wrap',
		],
		'top'  => [
			'name'      => __( 'Top Menu', 'arras' ),
			'container' => 'nav',
			/*'fallback'  => false,*/
			'depth'     => 1,
			'class'     => 'secondary-nav wrap',
		],
	],

	/**
	 * Theme supports.
	 */
	'theme-support'     => [
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

	/**
	 * Sidebar configurations.
	 */
	'sidebars'          => [
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
];