<?php
/**
 * Arras single (post) template.
 *
 * @package Arras
 *
 * @since 1.0.0
 */

get_header();

arras_above_content();

if ( have_posts() ) {

	while ( have_posts() ) {
		the_post();

		arras_above_post();
		?>
		<div id="post-<?php the_ID(); ?>" <?php arras_single_post_class(); ?>>

			<?php arras_postheader(); ?>

			<div class="entry-content">
				<?php the_content( __( '<p>Read the rest of this entry &raquo;</p>', 'arras' ) ); ?>
				<?php
				wp_link_pages( array(
					'before'         => __( '<p><strong>Pages:</strong> ', 'arras' ),
					'after'          => '</p>',
					'next_or_number' => 'number',
				) );
				?>
			</div>

			<?php arras_postfooter(); ?>

			<?php
			if ( arras_get_option( 'display_author' ) ) {
				arras_post_aboutauthor();
			}
			?>
		</div>

		<?php arras_below_post(); ?>

		<a name="comments"></a>

		<?php
		comments_template( '', true );

		arras_below_comments();
	}
} else {
	arras_post_notfound();
}

arras_below_content();

get_sidebar();
get_footer();
