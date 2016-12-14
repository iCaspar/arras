<?php
/**
 * HTML for displaying post author meta
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<div class="entry-author">
	<?php _ex( 'By ', 'Author byline, use space after', 'arras' ); ?>
    <address class="author vcard">
        <a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"
           rel="author" title="<?php echo esc_attr( get_the_author() ); ?>"><?php echo get_the_author(); ?></a>
    </address>
</div>
