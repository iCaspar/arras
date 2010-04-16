<?php get_header(); ?>

<?php $stickies = get_option('sticky_posts'); ?>

<div id="content" class="section">
<?php arras_above_content() ?>

<?php if (!$paged) : ?>

<?php if ( ( $featured1_cat = arras_get_option('slideshow_cat') ) !== '' && $featured1_cat != '-1' ) : ?>
    <!-- Featured Slideshow -->
    <div class="featured clearfix">
    <?php
	if ($featured1_cat == '-5') {
		if (count($stickies) > 0) 
			$query = array('post__in' => $stickies, 'showposts' => arras_get_option('slideshow_count') );
	} elseif ($featured1_cat == '0') {
		$query = 'showposts=' . arras_get_option('slideshow_count');
	} else {
		$query = 'showposts=' . arras_get_option('slideshow_count') . '&cat=' . $featured1_cat;
	}
	
	$q = new WP_Query( apply_filters('arras_slideshow_query', $query) );
	?> 
    	<div id="controls">
			<a href="" class="prev"><?php _e('Prev', 'arras') ?></a>
			<a href="" class="next"><?php _e('Next', 'arras') ?></a>
        </div>
    	<div id="featured-slideshow">
        	<?php $count = 0; ?>
		<?php remove_action('loop_end', 'dsq_loop_end'); // remove DISQUS action hook ?>
    		<?php if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post(); ?>
    		<div <?php if ($count != 0) echo 'style="display: none"'; ?>>

            	<a class="featured-article" href="<?php the_permalink(); ?>" rel="bookmark">
				<?php echo arras_get_thumbnail('featured-slideshow-thumb'); ?>
                <span class="featured-entry">
                    <span class="entry-title"><?php the_title(); ?></span>
                    <span class="entry-summary"><?php echo arras_strip_content(get_the_excerpt(), 20); ?></span>
					<span class="progress"></span>
                </span>
            	</a>
        	</div>
    		<?php $count++; endwhile; endif; ?>
		<?php add_action('loop_end', 'dsq_loop_end'); // add it back for other queries to use ?>
    	</div>
    </div>
<?php endif; ?>

<!-- Featured Articles -->
<?php if ( ($featured2_cat = arras_get_option('featured_cat') ) !== '' && $featured2_cat != '-1' ) : ?>
<div id="index-featured">
<div class="home-title"><?php _e( arras_get_option('featured_title') ) ?></div>
	<?php
	if ($featured2_cat == '-5') {
		if (count($stickies) > 0) 
			$query2 = array('post__in' => $stickies, 'showposts' => arras_get_option('featured_count') );
	} elseif ($featured2_cat == '0') {
		$query2 = 'showposts=' . arras_get_option('featured_count');
	} else {
		$query2 = 'showposts=' . arras_get_option('featured_count') . '&cat=' . $featured2_cat;
	}
	
	arras_render_posts($query2, arras_get_option('featured_display'), 'featured');
	?>
</div><!-- #index-featured -->
<?php endif; ?>


<?php arras_above_index_news_post() ?>

<!-- News Articles -->
<div id="index-news">
<div class="home-title"><?php _e( arras_get_option('news_title') ) ?></div>
<?php
$news_query_args = array(
	'cat' => arras_get_option('news_cat'),
	'paged' => $paged,
	'showposts' => ( (arras_get_option('index_count') == 0 ? get_option('posts_per_page') : arras_get_option('index_count')) )
);
query_posts($news_query_args);
arras_render_posts(null, arras_get_option('news_display'), 'news'); ?>

<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
	<div class="navigation clearfix">
		<div class="floatleft"><?php next_posts_link( __('Older Entries', 'arras') ) ?></div>
		<div class="floatright"><?php previous_posts_link( __('Newer Entries', 'arras') ) ?></div>
	</div>
<?php } ?>
</div><!-- #index-news -->

<?php arras_below_index_news_post() ?>

<?php $sidebars = wp_get_sidebars_widgets(); ?>

<div id="bottom-content-1">
	<?php if ( isset($sidebars['sidebar-4']) ) : ?>
	<ul class="clearfix xoxo">
    	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom Content #1') ) : ?>
        <?php endif; ?>
	</ul>
	<?php endif; ?>
</div>

<div id="bottom-content-2">
	<?php if ( isset($sidebars['sidebar-5']) ) : ?>
	<ul class="clearfix xoxo">
    	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom Content #2') ) : ?>
        <?php endif; ?>
	</ul>
	<?php endif; ?>
</div>

<?php else: ?>

<div class="home-title"><?php _e('Latest Headlines', 'arras') ?></div>

<div id="archive-posts">
	<?php arras_render_posts(null, arras_get_option('archive_display'), 'archive') ?>    
 
	<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
    	<div class="navigation clearfix">
			<div class="floatleft"><?php next_posts_link( __('&laquo; Older Entries', 'arras') ) ?></div>
			<div class="floatright"><?php previous_posts_link( __('Newer Entries &raquo;', 'arras') ) ?></div>
		</div>
    <?php } ?>
</div><!-- #archive-posts -->

<?php endif; ?>

<?php arras_below_content() ?>
</div><!-- #content -->
    
<?php get_sidebar(); ?>
<?php get_footer(); ?>