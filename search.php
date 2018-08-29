<?php get_header(); ?>

<?php arras_above_content() ?>

<?php if (have_posts()) : ?>
<div class="search-results">
    <h2 class="results-title"><?php _e('Search Results', 'arras') ?></h2>
    <div class="search-results-content clearfix">
	<p><?php _e('Search Results for', 'arras'); ?> <strong>&#8216;<?php echo esc_html($s); ?>&#8217;</strong></p>
    <?php get_search_form(); ?>
    </div>
</div>

<div id="archive-posts">
<?php arras_render_posts( null, arras_get_option('archive_display') ); ?>
</div>

<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
    <div class="entries-nav navigation clearfix">
	    <div class="next-posts floatright"><?php next_posts_link( __('&laquo; Older Entries', 'arras') ) ?></div>
	    <div class="previous-posts floatleft"><?php previous_posts_link( __('Newer Entries &raquo;', 'arras') ) ?></div>
    </div>
<?php } ?>

<?php else: ?>

<div class="search-results">
    <h2 class="results-title">Search Results</h2>
    <div class="search-results-content clearfix">
    <p><?php _e('<strong>Sorry, we couldn\'t find any results based on your search query.</strong>', 'arras') ?></p>
    <?php get_search_form() ?>
    </div>
</div> 

<h2 class="results-title home-title"><?php _e('Blog Archive', 'arras') ?></h2>
<?php arras_render_posts( null, arras_get_option('archive_display') ) ?>
    
<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
    <div class="entries-nav navigation clearfix">
		<div class="next-posts floatleft"><?php next_posts_link( __('&laquo; Older Entries', 'arras') ) ?></div>
		<div class="previous-posts floatright"><?php previous_posts_link( __('Newer Entries &raquo;', 'arras') ) ?></div>
    </div>
<?php } ?>  
<?php endif; ?>

<?php arras_below_content() ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>