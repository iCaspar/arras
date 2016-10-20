<?php
/**
 *	The Arras theme index.
 *	(Where the wild things are.)
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$arras = apply_filters( 'arras_template', 'index' );
?>

<?php include 'header.php'; ?>

<?php arras_above_content(); ?>

<div id="content" class="<?php echo $arras->layout_columns( 'content' ); ?>">
	<p>Here's the index page content.</p>
</div>

<?php arras_below_content() ?>

<?php include 'sidebar.php'; ?>

<?php include 'footer.php'; ?>
