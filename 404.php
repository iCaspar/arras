<?php
/**
 * Arras 404 ("not found") template.
 *
 * @package Arras
 *
 * @since 1.0.0
 */

get_header(); ?>

<?php arras_above_content(); ?>

<div class="single-post">
	<h1 class="entry-title"><?php esc_html_e( 'Something Went Missing!', 'arras' ); ?></h1>
	<div class="entry-content clearfix">
		<p><strong><?php esc_html_e( "We're very sorry, but that page doesn't exist or has been moved.", 'arras' ); ?></strong><br />
		<?php esc_html_e( 'Please make sure you have the right URL.', 'arras' ); ?>
		</p>
		<p><?php esc_html_e( "If you still can't find what you're looking for, try using the search form below.", 'arras' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</div>

<?php arras_below_content(); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
