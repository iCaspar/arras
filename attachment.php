<?php get_header(); ?>

<?php arras_above_content() ?>

<?php if (have_posts()) : the_post(); ?>
	<?php arras_above_post() ?>
	<div id="post-<?php the_ID() ?>" <?php arras_single_post_class() ?>>

        <?php arras_postheader() ?>

		<div class="entry-content single-post-attachment clearfix"><?php the_attachment_link($post->ID, false) ?>
		<?php the_content( __('<p>Read the rest of this entry &raquo;</p>', 'arras') ); ?>	
        
        <?php wp_link_pages(array('before' => __('<p><strong>Pages:</strong> ', 'arras'), 
			'after' => '</p>', 'next_or_number' => 'number')); ?>
        </div>
		
		<?php arras_postfooter() ?>

        <?php 
		if ( arras_get_option('display_author') ) {
			arras_post_aboutauthor();
		}
        ?>
    </div>
    
	<?php arras_below_post() ?>
	<?php comments_template('', true); ?>
	<?php arras_below_comments() ?>
    
<?php else: ?>

<?php arras_post_notfound() ?>

<?php endif; ?>

<?php arras_below_content() ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>