<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<?php
$posttypes = get_post_types(null, 'objects');
$posttypes_opt = array();

foreach( $posttypes as $id => $obj ) {
	if (!in_array( $id, arras_posttype_blacklist() )) {
		$posttypes_opt[$id] = $obj->labels->name;
	}
}

?>


<div id="posttype" class="padding-content">
<h3><?php _e('Home', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-posttype-slideshow"><?php _e('Slideshow', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-posttype-slideshow', $posttypes_opt, arras_get_option('slideshow_posttype') ); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-posttype-featured1"><?php _e('Featured Post #1', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-posttype-featured1', $posttypes_opt, arras_get_option('featured1_posttype') ); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-posttype-featured2"><?php _e('Featured Post #2', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-posttype-featured2', $posttypes_opt, arras_get_option('featured2_posttype') ); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-posttype-news"><?php _e('News Posts', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-posttype-news', $posttypes_opt, arras_get_option('news_posttype') ); ?>
</td>
</tr>

</table>

<?php do_action('arras_admin_posttype'); ?>
<input type="hidden" name="posttype" value="posttype" />

</div>

<!--
<p class="final-submit">
<input class="button-primary" type="submit" name="save" value="<?php// _e('Save Changes', 'arras') ?>" />
<input class="button-secondary" type="submit" name="reset" value="<?php// _e('Reset Settings', 'arras') ?>" />
</p>
-->


<?php

/* End of file posttax_page.php */
/* Location: ./library/admin/templates/posttax_page.php */
