<?php
/**
 * Arras Theme Header
 *
 * @package Arras
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$theme = apply_filters( 'arras_template', 'header' );
$arras = $theme[0];
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

	<div id="menu-top-container" class="menu-top-container">
		<?php $arras->do_menu( 'top' ); ?>
	</div>

	<?php arras_below_top_menu(); ?>

	<header id="page-header" class="page-header section">
		<div id="branding" class="top-banner wrap group">
			<div class="logo col span_2_of_3">
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; ?></p>
				<?php endif; ?>
			</div>

			<div class="sidebar headerwidgets col span_1_of_3">
				<ul class="xoxo">
					<?php if ( dynamic_sidebar( 'Header Widgets' ) ) {} ?>
				</ul>
			</div>
		</div>
	</header>

	<?php arras_above_nav(); ?>

	<div id="menu-main-container" class="menu-main-container">
		<?php $arras->do_menu( 'main' ); ?>
	</div>

	<?php arras_below_nav(); ?>

	<div id="body" class="page-body">

		<?php arras_above_main() ?>

		<div id="page-content" class="page-content wrap group">