<?php
/**
 * Arras theme sidebar template.
 */

/**
* @hooked ICaspar\Arras\Model\Arras::render(), priority 10
*/
$arras = apply_filters( 'arras_template', 'sidebar' );
?>

<?php if ( '1c' !== $arras->get_option( 'layout' ) ): // don't show sidebars on single column layout ?>

	<div id="primary" class="<?php echo $arras->layout_columns( 'primary' ); ?>">
	<?php arras_above_sidebar() ?>
		<ul class="xoxo">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Primary Sidebar') ) : ?>
				<li class="widgetcontainer clearfix">
					<h5 class="widgettitle"><?php _e('Welcome to Arras!', 'arras') ?></h5>
					<div class="widgetcontent">
					<div class="textwidget">
						<p><?php _e('Arras is a WordPress theme designed for news or review sites with lots of customisable features.', 'arras') ?></p>
					</div>
					</div>
				</li>
				<li class="widgetcontainer clearfix">
					<h5 class="widgettitle"><?php _e('Recent Posts', 'arras') ?></h5>
					<div class="widgetcontent">
	<?php
					$r = new WP_Query( array(
						'showposts' => 10,
						'what_to_show' => 'posts',
						'nopaging' => 0,
						'post_status' => 'publish',
						'ignore_sticky_posts' => 1
					) );

					if ($r->have_posts()) :
	?>
					<ul>
					<?php while ($r->have_posts()) : $r->the_post(); ?>
					<li><a href="<?php the_permalink() ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?> </a></li>
					<?php endwhile ?>
					</ul>
	<?php
					wp_reset_query();
					endif;
	?>
					</div>
				</li>
				<li class="widgetcontainer clearfix">
					<h5 class="widgettitle"><?php _e('Tag Cloud', 'arras') ?></h5>
					<div class="tags widgetcontent">
					<?php wp_tag_cloud(); ?>
					</div>
				</li>
			<?php endif; ?>
		</ul>
	</div><!-- #primary -->

	<?php if ( false !== strpos( $arras->get_option( 'layout' ), '3c' ) ): ?>
		<div id="secondary" class="<?php echo arras_layout_columns( 'secondary' ); ?>">
		    <ul class="xoxo">
		        <!-- Widgetized sidebar, if you have the plugin installed.  -->
		        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Secondary Sidebar') ) : ?>
				<li></li>
		        <?php endif; ?>
		    </ul>
			<?php arras_below_sidebar() ?>
		</div><!-- #secondary -->
	<?php endif; // end check for 2-column layout ?>
<?php endif; // end check for single column layout ?>
