<?php
/**
 * Arras Theme Header
 *
 * @package Arras
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'arras' ); ?></a>

	<?php arras_above_top_menu(); ?>

	<?php $arras->do_menu( 'top' ); ?>

	<?php arras_below_top_menu(); ?>

	<header id="header" class="page-header section">
		<div id="branding" class="top-banner wrap group">
			<div class="logo col span_2_of_3">
				<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"
				   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php if ( $arras->get_option( 'site_logo' ) ) :
//						arras_add_custom_logo();
					else: ?>
						<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
					<?php endif; ?>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</a>
			</div>
			<div class="sidebar headerwidgets col span_1_of_3">
				<ul class="xoxo">
					<?php if ( dynamic_sidebar( 'Header Widgets' ) ) {
						;
					} ?>
				</ul>
			</div>
		</div><!-- #branding -->
	</header><!-- #header -->

	<?php arras_above_nav(); ?>

	<?php $arras->do_menu( 'main' ); ?>

	<?php arras_below_nav(); ?>

	<div id="body" class="page-body">

		<?php arras_above_main() ?>

		<div id="container" class="wrap group main">