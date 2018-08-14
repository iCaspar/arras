<?php
/**
 * Arras header template.
 *
 * @package Arras
 *
 * @since 1.0.0
 */

?>

<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php arras_body_class(); ?>>

<?php arras_body(); ?>

<?php if ( has_nav_menu( 'top-menu' ) ) : ?>
	<div class="before-header secondary-nav-container secondary-nav">
		<?php arras_above_top_menu(); ?>
		<?php
		wp_nav_menu( [
			'sort_column'    => 'menu_order',
			'menu_class'     => 'secondary-nav-menu sf-menu menu clearfix',
			'theme_location' => 'top-menu',
			'depth'          => 1,
			'container'      => 'nav',
			'fallback_cb'    => false,
		] );
		?>
		<?php arras_below_top_menu(); ?>
	</div>
<?php endif; ?>

<div id="header" class="page-header">
	<div id="branding" class="site-banner">
		<div class="logo">
			<?php the_custom_logo(); ?>
			<?php if ( is_home() || is_front_page() ) : ?>
				<h1 class="site-name blog-name"><a
						href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description blog-description"><?php bloginfo( 'description' ); ?></h2>
			<?php else : ?>
				<p class="site-name blog-name"><a
						href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></p>
				<p class="site-description blog-description"><?php bloginfo( 'description' ); ?></p>
			<?php endif ?>
		</div>
	</div>
</div>

<?php arras_above_nav(); ?>

<div class="after-header primary-nav-container primary-nav">
	<div id="main-nav-wrap" class="main-nav-wrap">
		<?php
		wp_nav_menu( [
			'sort_column'    => 'menu_order',
			'menu_class'     => 'primary-nav-menu sf-menu menu clearfix',
			'theme_location' => 'main-menu',
			'container'      => 'nav',
			'fallback_cb'    => 'arras_nav_fallback_cb',
		] );

		arras_beside_nav();
		?>
	</div>
</div>

<?php arras_below_nav(); ?>

<div id="wrapper" class="wrap">

	<?php arras_above_main(); ?>

	<div id="main" class="main">
		<div id="container" class="content-container primary-content-container">
