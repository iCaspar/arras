<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div id="thumbnails" class="padding-content">

<h3><?php _e('Thumbnail Options', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Auto Thumbnails', 'arras') ?></th>
<td>

<?php echo arras_form_checkbox('arras-thumbs-auto', 'show', arras_get_option('auto_thumbs'), 'id="arras-thumbs-auto"') ?>
<label for="arras-thumbs-auto"><?php _e('Check this to allow the theme to automatically retrieve the first attached image from the post as featured image when no image is specified.', 'arras') ?></label>

</td>
</tr>
</table>

<h3><?php _e('Thumbnail Sizes', 'arras') ?></h3>

<table class="thumbnail-sizes-table form-table">
<?php foreach ($arras_image_sizes as $image_size_id => $image_size_args) : ?>
<tr valign="top">
<th scope="row"><label><?php echo $image_size_args['name'] ?></label></th>
<td>
<label for="arras-<?php echo $image_size_id ?>-w"><?php _e('Width', 'arras') ?></label>
<?php echo arras_form_input(array('name' => 'arras-' . $image_size_id . '-w', 'id' => 'arras-' . $image_size_id . '-w', 'size' => '5', 'value' => $image_size_args['w'], 'maxlength' => 3 )) ?><span class="default-w hide"><?php echo $image_size_args['dw'] ?></span>

<label for="arras-<?php echo $image_size_id ?>-h"><?php _e('Height', 'arras') ?></label>
<?php echo arras_form_input(array('name' => 'arras-' . $image_size_id . '-h', 'id' => 'arras-' . $image_size_id . '-h', 'size' => '5', 'value' => $image_size_args['h'], 'maxlength' => 3 )) ?><span class="default-h hide"><?php echo $image_size_args['dh'] ?></span>
</td>
<td class="arras-thumbnail-size-reset">
<a class="button-secondary"><?php _e('Reset to Defaults', 'arras') ?></a>
</td>
</tr>
<?php endforeach ?>
</table>

<script type="text/javascript">
	var j = jQuery.noConflict();
	j(document).ready(function() {
		j('.arras-thumbnail-size-reset .button-secondary').click( function() {
			j(this).parent().parent().children('td').find('input').eq(0).val( j(this).parent().parent().children('td').find('.default-w').html() );
			j(this).parent().parent().children('td').find('input').eq(1).val( j(this).parent().parent().children('td').find('.default-h').html() );
			checkRegenThumbsField();
		} );

		j('.thumbnail-sizes-table input').change( function() {
			checkRegenThumbsField();
		} );
	});
</script>

<?php do_action('arras_admin_settings-thumbnails'); ?>

</div><!-- #thumbnails -->
