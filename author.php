<?php get_header(); ?>

<?php arras_above_content() ?>

	<div class="author-content">
		<?php the_post(); // Get author information ?>
		<div class="author-box">
			<h1 class="entry-title"><?php printf( __( 'About Author: %s', 'arras' ), '<span class="vcard">' . get_the_author_meta( 'display_name' ) . '</span>' ); ?></h1>

			<div class="entry-content clearfix">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 96 ) ?></a>
				<?php if ( get_the_author_meta( 'user_url' ) ) : ?>
					<dl>
						<dt><?php _e( 'Website', 'arras' ) ?></dt>
						<dd><a href="<?php the_author_meta( 'user_url' ) ?>"><?php the_author_meta( 'user_url' ) ?></a>
						</dd>
					</dl>
				<?php endif ?>
				<?php if ( get_the_author_meta( 'description' ) ) : ?>
					<p class="author-meta"><?php the_author_meta( 'description' ) ?></p>
				<?php endif ?>
			</div>
		</div>
		<h2 class="author-posts-title"><?php printf( __( 'Posts by %s', 'arras' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author_meta( 'display_name' ) . '</a></span>' ); ?></h2>

		<div id="archive-posts">
			<?php arras_render_posts( 'author=' . get_the_author_meta( 'ID' ) . '&paged=' . $paged, arras_get_option( 'archive_display' ) ) ?>
		</div>

		<?php if ( function_exists( 'wp_pagenavi' ) ) {
			wp_pagenavi();
		} else { ?>
			<div class="entries-nav navigation clearfix">
				<div class="next-posts floatleft"><?php next_posts_link( __( '&laquo; Older Entries', 'arras' ) ) ?></div>
				<div class="previous-posts floatright"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'arras' ) ) ?></div>
			</div>
		<?php } ?>

	</div>

<?php arras_below_content() ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>