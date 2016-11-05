<?php
/**
 * The Arras author template.
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$arras = apply_filters( 'arras_template', 'author' );
?>

<?php get_header(); ?>

<?php arras_above_content() ?>

<div id="content" class="<?php echo $arras->layout_columns( 'content' ); ?>">

	<?php if ( have_posts() ): the_post(); ?>

		<h1 class="author-title"><?php printf( __( 'About Author: %s', 'arras' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author_meta( 'display_name' ) . '</a></span>' ); ?></h1>

		<div id="author-<?php the_ID(); ?>" <?php post_class( [ 'profile', 'group' ] ); ?>>
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 96 ) ?></a>
			<dl>
				<?php if ( get_the_author_meta( 'user_url' ) ) : ?>
					<dt><?php _e( 'Website', 'arras' ) ?></dt>
					<dd><a href="<?php the_author_meta( 'user_url' ) ?>"><?php the_author_meta( 'user_url' ) ?></a></dd>
				<?php endif ?>
				<?php if ( get_the_author_meta( 'description' ) ) : ?>
					<dt><?php _e( 'Description', 'arras' ) ?></dt>
					<dd><?php the_author_meta( 'description' ) ?></dd>
				<?php endif ?>
			</dl>
		</div>

		<h2 class="archive-title"><?php printf( __( 'Posts by %s', 'arras' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author_meta( 'display_name' ) . '</a></span>' ); ?></h2>

		<?php //arras_render_posts( 'author=' . get_the_author_meta('ID') . '&paged=' . $paged, arras_get_option( 'default_tapestry' ) ) ?>

		<?php $author_posts = $arras->run_query( [
			'author' => get_the_author_meta( 'ID' ),
			'paged'  => true,
		] ); ?>

		<?php if ( $author_posts->have_posts() ): ?>

			<?php while ( $author_posts->have_posts() ) : $author_posts->the_post(); ?>

				<div id="post-<?php the_ID() ?>" <?php post_class( [ 'traditional', 'group' ] ) ?>>
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

		<?php wp_reset_postdata(); ?>

	<?php endif; ?>

</div>

<?php arras_below_content() ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
