<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>


<div id="taxonomies" class="padding-content">

<h3><?php _e('Home', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-taxonomy-featured1"><?php _e('Featured Post #1', 'arras') ?></label></th>
<td>
<?php
  $featured1_tax_input = arras_form_dropdown( 'arras-taxonomy-featured1', arras_get_taxonomy_list(arras_get_option('featured1_posttype')), arras_get_option('featured1_tax') );
  if ( $featured1_tax_input != '' ) {
    echo $featured1_tax_input;
  } else {
    echo 'No Taxonomies available for selected Post Type.';
  }
?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-taxonomy-featured2"><?php _e('Featured Post #2', 'arras') ?></label></th>
<td>
<?php
  $featured2_tax_input = arras_form_dropdown( 'arras-taxonomy-featured2', arras_get_taxonomy_list(arras_get_option('featured2_posttype')), arras_get_option('featured2_tax') );
  if ( $featured2_tax_input != '' ) {
    echo $featured2_tax_input;
  } else {
    echo 'No Taxonomies available for selected Post Type.';
  }
?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-taxonomy-news"><?php _e('News Posts', 'arras') ?></label></th>
<td>
<?php
  $news_tax_input = arras_form_dropdown( 'arras-taxonomy-news', arras_get_taxonomy_list(arras_get_option('news_posttype')), arras_get_option('news_tax') );
  if ( $news_tax_input != '' ) {
    echo $news_tax_input;
  } else {
    echo 'No Taxonomies available for selected Post Type.';
  }
?>
</td>
</tr>

</table>

<?php do_action('arras_admin_taxonomy'); ?>

<p><?php _e('<strong>Note:</strong> Custom taxonomies require the <code>query_var</code> parameter to be defined to work.', 'arras') ?></p>
<input type="hidden" name="taxonomy" value="taxonomy" />

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
