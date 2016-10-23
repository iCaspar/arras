<?php
/**
 * HTML for author.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

?>
<div class="author-profile">
	<h4 class="profile-title">
		<?php _e( 'About the Author: ', 'arras' ); ?><?php the_author_posts_link(); ?></h4>
	<div class="profile-content">
		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 50, '', get_the_author(), [ 'class' => 'alignleft' ] ); ?>
		</a>
		<?php the_author_meta( 'description' ); ?>
	</div>
</div>

