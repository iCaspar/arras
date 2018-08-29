<?php
/**
 * assets.php
 */

return [
	'styles' => [
		'arras-nova' => [
			'nicename' => __( 'Arras Nova', 'arras' ),
			'filename' => 'style',
			'version'  => ARRAS_VERSION,
			'scheme'   => true,
		],
		'arras'      => [
			'nicename' => __( 'Arras 1.x', 'arras' ),
			'filename' => 'legacy/default',
			'version'  => ARRAS_VERSION,
			'scheme'   => true,
		],
		'blue'       => [
			'nicename' => __( 'Legacy Blue', 'arras' ),
			'filename' => 'legacy/blue',
			'version'  => ARRAS_VERSION,
			'scheme'   => true,
		],
		'green'      => [
			'nicename' => __( 'Legacy Green', 'arras' ),
			'filename' => 'legacy/green',
			'version'  => ARRAS_VERSION,
			'scheme'   => true,
		],
		'orange'     => [
			'nicename' => __( 'Legacy Orange', 'arras' ),
			'filename' => 'legacy/orange',
			'version'  => ARRAS_VERSION,
			'scheme'   => true,
		],
		'red'        => [
			'nicename' => __( 'Legacy Red', 'arras' ),
			'filename' => 'legacy/red',
			'version'  => ARRAS_VERSION,
			'scheme'   => true,
		],
		'violet'     => [
			'nicename' => __( 'Legacy Violet', 'arras' ),
			'filename' => 'legacy/violet',
			'version'  => ARRAS_VERSION,
			'scheme'   => true,
		],
		'legacy'     => [
			'nicename' => __( 'Legacy', 'arras' ),
			'filename' => 'legacy/legacy',
			'version'  => ARRAS_VERSION,
			'scheme'   => true,
		],
		'rtl'        => [
			'filename' => 'legacy/rtl',
			'version'  => ARRAS_VERSION,
		],
		'admin'      => [
			'filename' => 'admin',
			'version'  => ARRAS_VERSION,
			'deps'     => 'jquery-multi-select',
		],
		'admin-rtl'  => [
			'filename' => 'admin-rtl',
			'version'  => ARRAS_VERSION,
		],
		'jquery-multiselect' => [
			'filename' => 'jquery.multiselect',
			'version' => '2.0.1',
			'deps' => [ 'admin' ],
		],
		'smoothness' => [
			'filename' => 'jquery-ui-1.8.2.custom',
			'version'  => ARRAS_VERSION,
		],
	],
];