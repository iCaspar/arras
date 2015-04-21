<?php
/* Alternate Styles & Layouts Functions */
global $arras_layouts, $arras_registered_style_dirs;

register_style_dir( get_template_directory() . '/css/styles/' );


$arras_layouts = array(
	'1c'	=> __('1 Column Layout (No Sidebars)', 'arras'),
	'2c-r'	=> __('2 Column Layout (Right Sidebar)', 'arras'),
	'2c-l'	=> __('2 Column Layout (Left Sidebar)', 'arras'),
	'3c-lr'	=> __('3 Column Layout (Left & Right Sidebars)', 'arras'),
	'3c-2r'	=> __('3 Column Layout (2 Right Sidebars)', 'arras'),
);


function register_style_dir($dir) {
	global $arras_registered_style_dirs;
	$arras_registered_style_dirs[] = $dir;
}

function is_valid_arras_style($file) {
	return (bool)( !preg_match('/^\.+$/', $file) && preg_match('/^[A-Za-z][A-Za-z0-9\-]*.css$/', $file) );
}

function arras_override_styles() {
?>
<style type="text/css">
	/* These styles from Arras Theme */
<?php do_action('arras_custom_styles'); ?>
</style>
<?php
}

function arras_add_custom_logo() {
	$arras_logo_id = arras_get_option('logo');
	if ($arras_logo_id != 0) {
		$arras_logo = wp_get_attachment_image_src($arras_logo_id, 'full');

		echo '<img src="' . $arras_logo[0] . '" width="' . $arras_logo[1] . '" height="' . $arras_logo[2] . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />';
	}
}

function arras_load_styles() {
	global $arras_registered_alt_styles;

	if ( ! defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
		$scheme = arras_get_option( 'style' );
		$css_base_path = '/css/';
		if ( ! isset( $scheme ) ) $scheme = 'default';

		$css_path = $css_base_path . 'styles/' . $scheme;

		if ( $scheme != 'legacy' ) {
			if ( ! is_rtl() ) {
				wp_enqueue_style( 'arras-base', get_template_directory_uri() . $css_base_path . 'base.css', false, '1.6', 'all' );
				wp_enqueue_style( 'arras-default', get_template_directory_uri() . $css_base_path . 'styles/default.css', array( 'arras-base' ), '1.6', 'all' );
			} else {
				wp_enqueue_style( 'arras-base-rtl', get_template_directory_uri() . $css_base_path . 'base-rtl.css', false, '1.6', 'all' );
				wp_enqueue_style( 'arras-default-rtl', get_template_directory_uri() . $css_base_path . 'styles/default-rtl.css', array( 'arras-base-rtl' ), '1.6', 'all' );
			}
		}
		if ( is_rtl() ) $css_path .= '-rtl';
		if ( $scheme != 'default' ) {
			wp_enqueue_style( 'arras-schema', get_template_directory_uri() . $css_path . '.css', false, '1.6', 'all' );
		}
	}
	// load other custom styles
	do_action( 'arras_load_styles' );
}
