<?php
/**
 * Arras Theme Header
 *
 * Displays everything from begining to <div id="container">
 *
 * @package Arras
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_head(); // loads all the other <head> stuff ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'arras' ); ?></a>

	<?php arras_above_top_menu();

	if ( has_nav_menu( 'top-menu' ) ): ?>
		<div id="top-menu-section" class="primary-utility section group">
			<?php arras_menu( 'top-menu', false, 2, 'wrap' ); ?>
		</div>
	<?php endif; ?>

	<?php arras_below_top_menu(); ?>

	<header id="header" class="section">
		<div id="branding" class="wrap group">
			<div class="logo col span_2_of_3">
				<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php if (arras_get_option( 'logo' ) != 0 ) :
					arras_add_custom_logo();
				else: ?>
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
				<?php endif; ?>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</a>
			</div>
			<div class="sidebar headerwidgets col span_1_of_3">
				<ul class="xoxo">
					<?php if ( dynamic_sidebar('Header Widgets') ) ; ?>
				</ul>
			</div>
		</div><!-- #branding -->
	</header><!-- #header -->

	<?php arras_above_nav(); ?>

	<div id="main-nav-section" class="nav section group">
		<nav id="primary-nav" class="wrap">
			<?php arras_menu( 'main-menu', true, 3, 'col span_3_of_4' ); ?>
			<?php arras_beside_nav(); ?>
		</nav>
	</div>

	<?php arras_below_nav(); ?>

<div id="wrapper">

	<?php arras_above_main() ?>

	<div id="main" class="clearfix">
    <div id="container" class="clearfix">
