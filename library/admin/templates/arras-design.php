<?php
/**
 * Desplays Arras Options Page's Design tab
 * (Slated for removal)
 */
if ( ! defined( 'ABSPATH' ) ) die( 'No, Thank you!' ); // Exit if accessed directly
global $arras_color_schemes;
?>

<div id="design" class="padding-content">

<h3><?php _e('Overall Design', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-style"><?php _e('Default Style', 'arras') ?></label></th>
<td>
<?php if ( !defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
echo arras_form_dropdown('arras-style', $arras_color_schemes, arras_get_option('style') ) ?><br />
<?php printf( __('Alternate stylesheets can be placed in %s.', 'arras'), '<code>wp-content/themes/' .get_stylesheet(). '/css/styles/</code>' );
} else {
	echo '<span class="grey">' . __('The developer of the child theme has disabled alternate stylesheets.', 'arras') . '</span>';
}
?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-logo"><?php _e('Custom Logo', 'arras') ?></label></th>
<td>
<?php if ( arras_get_option('logo') != 0 ) {
	echo wp_get_attachment_image(arras_get_option('logo'), 'full') . '<br />';
	echo arras_form_checkbox('arras-delete-logo', 'show', false, 'id="arras-delete-logo"');
?>
	<label for="arras-delete-logo"><?php _e('Delete existing', 'arras') ?></label>
<?php } ?>
<p id="arras-logo-field"><input type="file" id="arras-logo" name="arras-logo" size="35" /></p>
</td>
</tr>

<tr valign="top">
	<th scope="row"><label for "arras-header-color"><?php _e('Custom Header Color', 'arras') ?></label></th>
	<td><input name="arras-header-color" type="text" value="<?php echo esc_attr( arras_get_option( 'header_color' ) );?>" class="wp-color-picker-field" /></td>
</tr>

</table>

<?php do_action('arras_admin_settings-design'); ?>

</div><!-- #design -->
