<?php
/**
 * HTML to show when no posts have been found.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<div class="single-post">
    <h1 class="entry-title"><?php _e( 'That \'something\' you are looking for isn\'t here!', 'arras' ); ?></h1>
    <div class="entry-content">
        <p>
            <strong><?php _e( 'We\'re very sorry, but the page that you are looking for doesn\'t exist or has been moved.', 'arras' ); ?></strong><br>
			<?php _e( 'Perhaps searching for it might help?', 'arras' ); ?></p>
		<?php get_search_form(); ?>
        <h3><?php _e( 'Latest Posts', 'arras' ); ?></h3>
        <ul>
			<?php wp_get_archives( 'type=postbypost&limit=10&format=custom&before=<li>&after=</li>' ); ?>
        </ul>
    </div>
</div>