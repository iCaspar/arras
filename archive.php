<?php
/**
 * The Arras archives template.
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$arras = apply_filters( 'arras_template', 'archive' );
?>

<?php get_header(); ?>

<?php arras_above_content() ?>

<div id="content" class="<?php echo $arras->layout_columns( 'content' ); ?>">

<?php is_tag(); if ( have_posts() ) : ?>
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

	<?php if ( is_category() ) : ?>
        <h1 class="archive-title"><?php printf( __('%s Archive', 'arras'), single_cat_title('', false) ) ?></h1>
    <?php elseif ( is_tag() ) : ?>
        <h1 class="archive-title"><?php printf( __('%s Archive', 'arras'), single_tag_title('', false) ) ?></h1>
	<?php elseif ( is_tax() ) : $term = $wp_query->get_queried_object(); ?>
		<h1 class="archive-title"><?php printf( __('%s Archive', 'arras'), $term->name ) ?></h1>
    <?php elseif ( is_day() ) : ?>
        <h1 class="archive-title"><?php printf( __('Archive for %s', 'arras'), get_the_time( __('F jS, Y', 'arras') ) ) ?></h1>
    <?php elseif ( is_month() ) : ?>
        <h1 class="archive-title"><?php printf( __('Archive for %s', 'arras'), get_the_time( __('F, Y', 'arras') ) ) ?></h1>
    <?php elseif ( is_year() ) : ?>
        <h1 class="archive-title"><?php printf( __('Archive for %s', 'arras'), get_the_time( __('Y', 'arras') ) ) ?></h1>
    <?php elseif ( is_author() ) : ?>
        <h1 class="archive-title"><?php _e('Author Archive', 'arras') ?></h1>
    <?php else : ?>
        <h1 class="archive-title"><?php _e('Archives', 'arras') ?></h1>
    <?php endif; ?>

<?php //arras_render_posts( null, ( arras_get_option( 'default_tapestry' ) ) ? arras_get_option( 'default_tapestry' ) : 'quick' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class( [ 'traditional', 'group' ] ); ?>>
			<?php $arras->postheader() ?>
			<div
				class="entry-content"><?php the_content( __( 'Read the rest of this entry &raquo;', 'arras' ) ); ?>
			</div>
			<?php $arras->postfooter() ?>
		</div>

	<?php endwhile; ?>

	<?php the_posts_navigation( [
		'prev_text' => '<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ' . _x( 'Older Posts', 'Previous post link', 'arras' ),
		'next_text' => _x( 'Newer Posts', 'Next post link', 'arras' ) . ' <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>',
	] ); ?>

<?php else: ?>
	<?php $arras->post_notfound() ?>

<?php endif; ?>

</div>


<?php arras_below_content() ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
