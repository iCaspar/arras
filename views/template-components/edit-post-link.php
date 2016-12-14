<?php
/**
 * HTML for an edit post link.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<a class="post-edit-link" href="<?php echo get_edit_post_link( $id ); ?>"><?php _ex( '(Edit Post)', 'Edit post link', 'arras' ); ?></a>