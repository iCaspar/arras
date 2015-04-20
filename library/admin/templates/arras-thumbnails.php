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

</div><!-- #thumbnails -->
