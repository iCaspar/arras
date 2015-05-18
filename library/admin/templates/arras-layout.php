<?php
/**
 * Desplays Arras Options Page's Layout tab
 * (Slated for removal)
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $arras_layouts;

$cats = array('0' => __('All Categories', 'arras') );
foreach( get_categories('hide_empty=0') as $c ) {
	$cats[(string)$c->cat_ID] = $c->cat_name;
}
?>

<div id="layout" class="padding-content">

<h3><?php _e('Single Post', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Display in Single Posts', 'arras') ?></th>
<td>

<?php echo arras_form_checkbox('arras-layout-post-author', 'show', arras_get_option('post_author'), 'id="arras-layout-post-author"') ?>
<label for="arras-layout-post-author"><?php _e('Author (Header)', 'arras') ?></label>
<br />

<?php echo arras_form_checkbox('arras-layout-post-date', 'show', arras_get_option('post_date'), 'id="arras-layout-post-date"') ?>
<label for="arras-layout-post-date"><?php _e('Publish Date (Header)', 'arras') ?></label>
<br />

<?php echo arras_form_checkbox('arras-layout-post-cats', 'show', arras_get_option('post_cats'), 'id="arras-layout-post-cats"') ?>
<label for="arras-layout-post-cats"><?php _e('Categories (Header)', 'arras') ?></label>
<br />

<?php echo arras_form_checkbox('arras-layout-post-tags', 'show', arras_get_option('post_tags'), 'id="arras-layout-post-tags"') ?>
<label for="arras-layout-post-tags"><?php _e('Tags', 'arras') ?></label>
<br />

<?php echo arras_form_checkbox('arras-layout-single-thumbs', 'show', arras_get_option('single_thumbs'), 'id="arras-layout-single-thumbs"') ?>
<label for="arras-layout-single-thumbs"><?php _e('Post Thumbnail', 'arras') ?></label>
<br />

<?php echo arras_form_checkbox('arras-layout-single-author', 'show', arras_get_option('display_author'), 'id="arras-layout-single-author"') ?>
<label for="arras-layout-single-author"><?php _e('Author Information', 'arras') ?></label>

</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Display Relative Post Dates', 'arras') ?></th>
<td>

<?php echo arras_form_checkbox('arras-layout-single-postdates', 'show', arras_get_option('relative_postdates'), 'id="arras-layout-single-postdates"') ?>
<label for="arras-layout-single-author"><?php _e('Check this to display post dates relative to current time (eg. 2 days ago ).', 'arras') ?></label>

</td>
</tr>


</table>

<?php do_action('arras_admin_settings-layout'); ?>

</div><!-- #layout -->
