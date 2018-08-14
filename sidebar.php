</div>

<?php if ( is_active_sidebar( 'primary' ) ) : ?>

	<div id="primary" class="aside main-aside sidebar primary-sidebar">

		<?php arras_above_sidebar(); ?>

		<div class="widget-area xoxo">
			<?php dynamic_sidebar( 'primary' ); ?>
		</div>

	</div>

<?php endif; ?>

<?php if ( is_active_sidebar( 'secondary' ) ): ?>

	<div id="secondary" class="aside main-aside sidebar secondary-sidebar">
		<div class="widget-area xoxo">
			<?php dynamic_sidebar( 'secondary' ); ?>
		</div>
	</div>
<?php endif;

arras_below_sidebar();
