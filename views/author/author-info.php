<?php
/**
 * Html for author information.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<h1 class="author-title">
	<?php printf( __( 'About Author: %s', 'arras' ), '<span class="vcard"><a class="url fn n" href="'
	                                                 . get_author_posts_url( get_the_author_meta( 'ID' ) )
	                                                 . '" title="' . esc_attr( get_the_author() )
	                                                 . '" rel="me">'
	                                                 . get_the_author_meta( 'display_name' )
	                                                 . '</a></span>' ); ?>
</h1>

<div id="author-<?php the_ID(); ?>" <?php post_class(); ?>>
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

<h2 class="archive-title">
	<?php printf( __( 'Posts by %s', 'arras' ), '<span class="vcard"><a class="url fn n" href="'
	                                            . get_author_posts_url( get_the_author_meta( 'ID' ) )
	                                            . '" title="' . esc_attr( get_the_author() )
	                                            . '" rel="me">'
	                                            . get_the_author_meta( 'display_name' )
	                                            . '</a></span>' ); ?>
</h2>
