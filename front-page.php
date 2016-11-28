<?php
/**
 * Arras front-page template.
 */

if ( is_front_page() && is_home() ) {
	include ARRAS_THEME_DIR . '/index.php';
} else {
	/**
	 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
	 */
	$arras = apply_filters( 'arras_template', 'front-page' );
	$paged = get_query_var( 'page' );
	?>

	<?php get_header(); ?>

	<?php
//$stickies = get_option( 'sticky_posts' );
//rsort( $stickies );
	/*
		$slideshow_cat = $arras->get_option( 'slideshow_cat' );
		$featured1_cat = $arras->get_option( 'featured1_cat' );
		$featured2_cat = $arras->get_option( 'featured2_cat' );
		$news_cat      = $arras->get_option( 'news_cat' );

		$slideshow_count = (int) $arras->get_option( 'slideshow_count' );
		$featured1_count = (int) $arras->get_option( 'featured1_count' );
		$featured2_count = (int) arras_get_option( 'featured2_count' );

		$post_blacklist = array();
	/*/
	?>

	<div id="content" class="<?php echo $arras['layout']->get_classes( 'content' ); ?>">
		<?php arras_above_content(); // if the Slideshow is active it is loaded here ?>

		<?php if ( ! $paged ) : ?>

			<?php if ( false !== $arras['options']->get( 'enable_featured1' ) ) : ?>
				<?php arras_above_index_featured1_post() ?>
				<!-- Featured Articles #1 -->

				<div id="index-featured1" class="section group">
					<?php if ( $arras['options']->get( 'featured1_title' ) != '' ) : ?>
						<h2 class="home-title"><?php _e( $arras->get_option( 'featured1_title' ), 'arras' ) ?></h2>
					<?php endif;
					/*					arras_featured_loop( $arras->get_option( 'featured1_display' ), apply_filters( 'arras_featured1_query', array(
											'list'     => $featured1_cat,
											'taxonomy' => $arras->get_option( 'featured1_tax' ),
											'query'    => array(
												'posts_per_page'      => $featured1_count,
												'exclude'             => $post_blacklist,
												'ignore_sticky_posts' => true,
												'post_type'           => $arras->get_option( 'featured1_posttype' )
											)
										) ) );
										*/ ?>
				</div><!-- #index-featured1 -->
			<?php endif ?>

			<?php if ( false !== $arras['options']->get( 'enable_featured2' ) ) : ?>
				<?php arras_above_index_featured2_post() ?>
				<!-- Featured Articles #2 -->
				<div id="index-featured2">
					<?php if ( $arras['options']->get( 'featured2_title' ) != '' ) : ?>
						<h2 class="home-title"><?php _e( $arras->get_option( 'featured2_title' ), 'arras' ) ?></h2>
					<?php endif;
					/*					arras_featured_loop( $arras->get_option( 'featured2_display' ), apply_filters( 'arras_featured2_query', array(
											'list'     => $featured2_cat,
											'taxonomy' => $arras->get_option( 'featured2_tax' ),
											'query'    => array(
												'posts_per_page'      => $featured2_count,
												'exclude'             => $post_blacklist,
												'ignore_sticky_posts' => true,
												'post_type'           => $arras->get_option( 'featured2_posttype' )
											)
										) ) );
										*/ ?>

				</div><!-- #index-featured2 -->
			<?php endif; ?>

			<?php if ( $arras['options']->get( 'enable-news' ) ) : ?>

				<?php //$arras->do_the_news(); ?>
				<p>Content goes here.</p>

			<?php endif; ?>

			<?php //arras_main_column_widgets() ?>

		<?php else: // We're on a second (or subsequent) page from the news section ?>

			<?php// $arras->do_the_news(); ?>

			<?php arras_below_index_news_post() ?>

		<?php endif; ?>

	</div>

	<?php arras_below_content() ?>

	<?php get_sidebar(); ?>

	<?php get_footer(); ?>

<?php }