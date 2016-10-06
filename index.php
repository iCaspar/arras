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

<p>Here's the index page content.</p>

<?php include 'sidebar.php'; ?>

<?php include 'footer.php'; ?>
