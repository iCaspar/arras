</div>

<div id="primary" class="aside main-aside sidebar primary-sidebar">
	<?php arras_above_sidebar() ?>
    <ul class="xoxo">
		<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'primary' ) ) : ?>
            <li class="widgetcontainer clearfix">
                <h5 class="widgettitle"><?php _e( 'Welcome to Arras!', 'arras' ) ?></h5>
                <div class="widgetcontent">
                    <div class="textwidget">
                        <p><?php _e( 'Arras is a WordPress theme designed for news or review sites with lots of customisable features.', 'arras' ) ?></p>
                    </div>
                </div>
            </li>
            <li class="widgetcontainer clearfix">
                <h5 class="widgettitle"><?php _e( 'Recent Posts', 'arras' ) ?></h5>
                <div class="widgetcontent">
					<?php
					$r = new WP_Query( array(
						'showposts'           => 10,
						'what_to_show'        => 'posts',
						'nopaging'            => 0,
						'post_status'         => 'publish',
						'ignore_sticky_posts' => 1
					) );
					if ( $r->have_posts() ) :
						?>
                        <ul>
							<?php while ( $r->have_posts() ) : $r->the_post(); ?>
                                <li><a href="<?php the_permalink() ?>"><?php if ( get_the_title() ) {
											the_title();
										} else {
											the_ID();
										} ?> </a></li>
							<?php endwhile ?>
                        </ul>
						<?php
						wp_reset_postdata();
					endif;
					?>
                </div>
            </li>
            <li class="widgetcontainer clearfix">
                <h5 class="widgettitle"><?php _e( 'Tag Cloud', 'arras' ) ?></h5>
                <div class="tags widgetcontent">
					<?php wp_tag_cloud(); ?>
                </div>
            </li>
		<?php endif; ?>
    </ul>
</div>
<?php if ( is_active_sidebar( 'secondary' ) ): ?>
    <div id="secondary" class="aside main-aside sidebar secondary-sidebar">
        <ul class="xoxo">
			<?php dynamic_sidebar( 'secondary' ); ?>
        </ul>
    </div>
<?php endif;
arras_below_sidebar();
