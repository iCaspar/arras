<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php global $arras_registered_alt_layouts ?>

<?php
$arras = apply_filters( 'arras_theme', null );
$styleSchemes = $arras->getStyleSchemes();
$stylesMenuOpts = [];

foreach ($styleSchemes as $scheme) {
    $stylesMenuOpts[strtolower($scheme)] = $scheme;
}
?>

<div id="design" class="padding-content">

<h3><?php _e('Overall Design', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-col"><?php _e('Overall Layout', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-layout-col', $arras_registered_alt_layouts, arras_get_option('layout')) ?>
    <br />
    <?php echo arras_form_checkbox('arras-reset-thumbs', 'show', false, 'id="arras-reset-thumbs"') . ' ';
	_e('Reset thumbnail sizes accordingly based on selected layout.', 'arras');
?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-style"><?php _e('Default Style', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-style', $stylesMenuOpts, arras_get_option('style') ) ?><br />
</td>
</tr>

</table>

<?php do_action('arras_admin_settings-design'); ?>

</div>
