<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div id="general-settings" class="padding-content">

<h3><?php _e('Theme Information', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Current Version', 'arras') ?></th>
<td class="version">
<span class="number"><?php echo ARRAS_VERSION ?></span>
<p><?php _e('If you have recently upgraded Arras to a new release, it is <span style="color: red">highly recommended</span> that you reset your theme options, clear your browser cache and restart your browser before proceeding.', 'arras') ?></p>
</td>
</tr>

</table>

<h3><?php _e('Site Information', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-rss-feed-url"><?php _e('RSS Feed (URL)', 'arras') ?></label></th>
<td>
<code><?php echo get_bloginfo( 'rss2_url' ) ?></code><br />
<?php _e( 'Custom feed URLs are no longer allowed due to support for automatic feed links.', 'arras' ) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-rss-comments-url"><?php _e('RSS Comments Feed (URL)', 'arras') ?></label></th>
<td>
<code><?php echo get_bloginfo( 'comments_rss2_url' ) ?></code><br />
<?php _e( 'Custom feed URLs are no longer allowed due to support for automatic feed links.', 'arras' ) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-twitter"><?php _e('Twitter Username', 'arras') ?></label></th>
<td>
<?php echo htmlentities('http://www.twitter.com/') ?><?php echo arras_form_input(array('name' => 'arras-twitter', 'id' => 'arras-twitter', 'class' => 'code', 'size' => '15', 'value' => arras_get_option('twitter_username') )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-facebook"><?php _e('Facebook Profile (URL)', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-facebook', 'id' => 'arras-facebook', 'class' => 'code', 'size' => '65', 'value' => arras_get_option('facebook_profile') )) ?><br />
<?php _e('Link to your Facebook profile.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-flickr"><?php _e('Flickr Profile (URL)', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-flickr', 'id' => 'arras-flickr', 'class' => 'code', 'size' => '65', 'value' => arras_get_option('flickr_profile') )) ?><br />
<?php _e('Link to your Flickr profile.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-gplus"><?php _e('Google+ Profile (URL)', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-gplus', 'id' => 'arras-gplus', 'class' => 'code', 'size' => '65', 'value' => arras_get_option('gplus_profile') )) ?><br />
<?php _e('Link to your Google+ profile.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-youtube"><?php _e('YouTube Profile (URL)', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-youtube', 'id' => 'arras-youtube', 'class' => 'code', 'size' => '65', 'value' => arras_get_option('youtube_profile') )) ?><br />
<?php _e('Link to your YouTube profile.', 'arras') ?>
</td>
</tr>

</table>

<p style="margin: 1em 0.5em; font-size: 12px;">
	<strong><?php _e( 'Credits:', 'arras' ) ?></strong>
	<?php _e( 'Google+ Icon from <a href="http://themedy.com/free-google-icons">Themedy</a>. Other social icons from <a href="http://19eighty7.com/icons">19eighty7</a>.', 'arras' ) ?>
</p>

</table>

<?php do_action('arras_admin_settings-general'); ?>

</div><!-- #general-settings -->
