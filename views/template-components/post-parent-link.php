<?php
/**
 * HTML for a post parent link.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>
<p class="post-parent-link entry-meta">[<a href="<?php echo get_permalink( $post->post_parent ); ?>" rel="attachment"><?php echo get_the_title( $post->post_parent ); ?></a>]</p>