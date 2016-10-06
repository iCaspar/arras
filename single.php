<?php
/**
* @hooked ICaspar\Arras\Model\Arras::render(), priority 10
*/
$arras = apply_filters( 'arras_template', 'index' );
?>

<?php include 'header.php'; ?>

<div id="content" class="<?php //echo arras_layout_columns( 'content' ); ?>">
<?php arras_above_content() ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php arras_above_post() ?>
	<div id="post-<?php the_ID() ?>" <?php //arras_single_post_class() ?>>

        <?php //arras_postheader() ?>

        <div class="entry-content clearfix">
		<?php the_content( __('<p>Read the rest of this entry &raquo;</p>', 'arras') ); ?>
        <?php wp_link_pages(array('before' => __('<p><strong>Pages:</strong> ', 'arras'),
			'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div>

		<?php //arras_postfooter() ?>

        <?php
		if ( $arras->get_option('display_author') ) {
	//		arras_post_aboutauthor();
		}
        ?>
    </div>
  <?php //arras_post_nav() ?>
	<?php arras_below_post() ?>
	<a name="comments"></a>
    <?php comments_template('', true); ?>
	<?php arras_below_comments() ?>

<?php endwhile; else: ?>

<?php //arras_post_notfound() ?>

<?php endif; ?>

<?php arras_below_content() ?>
</div><!-- #content -->

<?php include 'sidebar.php'; ?>
<?php include 'footer.php'; ?>
