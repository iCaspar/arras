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
		'layout'              => 'NoSidebars',
		'display-author-page' => true,
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
		'layout' => [
			'class'     => 'ICaspar\Arras\Theme\Layouts\LayoutFactory',
			'option' => 'layout',
		],
	],
];